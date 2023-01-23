import requests
import json

def createAgent(name, gender, agent_class, position) :
    api_url = "http://127.0.0.1:5000/create"
    todo = {"name": name, "gender": gender, "class": agent_class, "position": position}
    response = requests.post(api_url, json=todo)
    return response.json()

def getAgentsList() :
    api_url = "http://127.0.0.1:5000/agents"
    response = requests.get(api_url)
    return json.dumps(response.json(), indent=4)

def getAgent(agent_id) :
    api_url = "http://127.0.0.1:5000/agents/"+agent_id
    response = requests.get(api_url)
    return json.dumps(response.json(), indent=4)

def deleteAgent(agent_id) :
    api_url = "http://127.0.0.1:5000/delete/"+agent_id
    response = requests.delete(api_url)
    return response.json()
    
def UpdateAgent(agent_id, name, gender, agent_class, position) :
    api_url = "http://127.0.0.1:5000/update"
    todo = {"id": agent_id, "name": name, "gender": gender, "class": agent_class, "position": position}
    response = requests.put(api_url, json=todo)
    return response.json()

def schools_list(nom, commune) :
    api_url = "http://127.0.0.1:5000/gouvapi/"+nom+"/"+commune
    response = requests.get(api_url)
    return json.dumps(response.json(), indent=4)

#print(schools_list("furet", "antony"))
print(getAgentsList())
print(getAgent(str(2)))
#print(createAgent("Harbor", "M", 2, 4))
#print(UpdateAgent(1, "Killjoy", "F", 1, 1))
#print(deleteAgent("8"))
