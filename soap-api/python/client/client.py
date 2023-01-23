import zeep
from zeep import Client
from zeep import xsd
#import lxml.etree as etree
import xml.dom.minidom
import xmltodict, json
import numpy as np
#client = Client(wsdl)

class MyClient:
    """SAOP Client from the PHP server"""

    def __init__(self):
        self.client = Client('http://localhost/Projet_SW/soap-api/wsdl/MonServeur.wsdl')

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
            return new_xml

    def getAgentClass(self, agentName):
        with self.client.settings(raw_response=True):

            response = self.client.service.getAgentClass(agentName)
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

    def getLocationsList(self):
        with self.client.settings(raw_response=True):

            response = self.client.service.getLocationsList()
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

    def getClassesList(self):
        with self.client.settings(raw_response=True):

            response = self.client.service.getClassesList()
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

    def addAgent(self, agentName, agentGender, agentClass, agentPosition):
        with self.client.settings(raw_response=True):

            response = self.client.service.addAgent(agentName, agentGender, agentClass, agentPosition)
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

    def addClass(self, className, classDescription):
        with self.client.settings(raw_response=True):

            response = self.client.service.addClass(className, classDescription)
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

    def deleteAgent(self, agentId):
        with self.client.settings(raw_response=True):

            response = self.client.service.deleteAgent(agentId)
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

    def updateAgentInfo(self, agentId, agentName, agentGender, agentClass, agentPosition):
        with self.client.settings(raw_response=True):

            response = self.client.service.updateAgentInfo(agentId, agentName, agentGender, agentClass, agentPosition)
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

    def getCityNameFromCP(self, postalCode):
        with self.client.settings(raw_response=True):

            response = self.client.service.getCityNameFromCP(postalCode)
            temp = xml.dom.minidom.parseString(response.content)
            new_xml = temp.toprettyxml()
            with open('client.xml', 'w') as f:
                f.write(new_xml)
            return new_xml

cli = MyClient()        
print(cli.getAgentsList())
#print(cli.getAgentClass("Omen"))
#print(cli.getLocationsList())
#print(cli.getClassesList())
#print(cli.addAgent("Fade", "F", 3, 4))
#print(cli.addClass("Duelliste", "Sorts de combats"))
#print(cli.deleteAgent(9))
#print(cli.updateAgentInfo(1, "Killjo", "M", 1, 5))
#print(cli.getCityNameFromCP(45000))

