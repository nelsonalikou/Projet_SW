from flask import Flask
import zeep
from zeep import Client
from zeep import xsd
#import lxml.etree as etree
import xml.dom.minidom
import xmltodict, json
import numpy as np

app = Flask(__name__)

class MyClient:
    """SAOP Client from the PHP server"""

    def __init__(self):
        self.client = Client('http://localhost/Projet_SW/wsdl/MonServeur.wsdl')

    #client = zeep.Client(wsdl=wsdl)
    #print(client.service.getAgentsList())

    def getAgentsList(self):
        with self.client.settings(raw_response=True):
            """#Recuperation de la liste des agents
            response = client.service.getAgentsList()

            # response is now a regular requests.Response object
            assert response.status_code == 200
            assert response.content
            #x = etree.parse(response.content)
            #print(etree.tostring(x, pretty_print=True))
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            #print(new_xml)
            o = xmltodict.parse(response.content)
            #print(json.dumps(o, indent=4))"""

            response = self.client.service.getAgentsList()
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)


    def getAgentClass(self, agentName):
        with self.client.settings(raw_response=True):
            """#Recuperation de la liste des agents
            response = client.service.getAgentsList()

            # response is now a regular requests.Response object
            assert response.status_code == 200
            assert response.content
            #x = etree.parse(response.content)
            #print(etree.tostring(x, pretty_print=True))
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            #print(new_xml)
            o = xmltodict.parse(response.content)
            #print(json.dumps(o, indent=4))"""

            response = self.client.service.getAgentClass(agentName)
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            #print(new_xml)
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return 'g=he'

@app.route('/')
def hello():
    #return '<!doctype html> <html lang="en">   <head>     <!-- Required meta tags -->     <meta charset="utf-8">     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">      <!-- Bootstrap CSS -->     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">      <title>Hello, world!</title>   </head>   <body>     <h1>Hello, world!</h1>      <!-- Optional JavaScript -->     <!-- jQuery first, then Popper.js, then Bootstrap JS -->     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   </body> </html>'
    cli = MyClient()        
    return cli.getAgentClass("omen")

@app.route('/about')
def about():
    return '<h3>This is a Flask web application.</h3>'