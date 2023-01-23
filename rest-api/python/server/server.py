import pymysql
from app import app
from config import mysql
from flask import jsonify
from flask import flash, request
import requests

@app.route('/create', methods=['POST'])
def create_agent():
    try:        
        _json = request.json
        _name = _json['name']
        _gender = _json['gender']
        _class = _json['class']
        _position = _json['position']	
        if _name and _gender and _class and _position and request.method == 'POST':
            conn = mysql.connect()
            cursor = conn.cursor(pymysql.cursors.DictCursor)		
            sqlQuery = "INSERT INTO agents (name, gender, class, position) VALUES(%s, %s, %s, %s)"
            bindData = (_name, _gender, _class, _position,)            
            cursor.execute(sqlQuery, bindData)
            conn.commit()
            respone = jsonify('Agent added successfully!')
            respone.status_code = 200
            return respone
        else:
            return showMessage()
    except Exception as e:
        print(e)
    finally:
        cursor.close() 
        conn.close()          
     
@app.route('/agents')
def agent():
    try:
        conn = mysql.connect()
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        cursor.execute("SELECT a.id as id, a.name as name, c.name as class, gender,  l.cp as cp  FROM agents as a INNER JOIN classes as c on (a.class=c.id) INNER JOIN localisation as l on (a.position=l.id)")
        agentRows = cursor.fetchall()
        respone = jsonify(agentRows)
        respone.status_code = 200
        return respone
    except Exception as e:
        print(e)
    finally:
        cursor.close() 
        conn.close()  

@app.route('/agents/<agent_id>', methods=['GET'])
def agent_details(agent_id):
    try:
        conn = mysql.connect()
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        cursor.execute("SELECT a.id as id, a.name as name, c.name as class, gender,  l.cp as cp  FROM agents as a INNER JOIN classes as c on (a.class=c.id) INNER JOIN localisation as l on (a.position=l.id) WHERE a.id =%s", [agent_id])
        agentRow = cursor.fetchone()
        respone = jsonify(agentRow)
        respone.status_code = 200
        return respone
    except Exception as e:
        print(e)
    finally:
        cursor.close() 
        conn.close()

@app.route('/update', methods=['PUT'])
def update_agent():
    try:
        _json = request.json
        _id = _json['id']
        _name = _json['name']
        _gender = _json['gender']
        _class = _json['class']
        _position = _json['position']
        if _name and _gender and _class and _position and _id and request.method == 'PUT':			
            sqlQuery = "UPDATE agents SET name=%s, gender=%s, class=%s, position=%s WHERE id=%s"
            bindData = (_name, _gender, _class, _position, _id,)
            conn = mysql.connect()
            cursor = conn.cursor()
            cursor.execute(sqlQuery, bindData)
            conn.commit()
            respone = jsonify('Agent informations updated successfully!')
            respone.status_code = 200
            return respone
        else:
            return showMessage()
    except Exception as e:
        print(e)
    finally:
        cursor.close() 
        conn.close() 

@app.route('/delete/<agent_id>', methods=['DELETE'])
def delete_agent(agent_id):
	try:
		conn = mysql.connect()
		cursor = conn.cursor()
		cursor.execute("DELETE FROM agents WHERE id =%s", [agent_id])
		conn.commit()
		respone = jsonify('Agent deleted successfully!')
		respone.status_code = 200
		return respone
	except Exception as e:
		print(e)
	finally:
		cursor.close() 
		conn.close()

@app.route('/gouvapi/<nom>/<commune>')
def schools_list(nom, commune):
    api_url = "https://acceslibre.beta.gouv.fr/api/erps/?q="+nom+"&commune="+commune
    response = requests.get(api_url)
    return response.json()
       
@app.errorhandler(404)
def showMessage(error=None):
    message = {
        'status': 404,
        'message': 'Record not found: ' + request.url,
    }
    respone = jsonify(message)
    respone.status_code = 404
    return respone
        
if __name__ == "__main__":
    app.run()