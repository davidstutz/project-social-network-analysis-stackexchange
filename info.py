#! /usr/bin/python

import igraph
import os
import numpy

def print_igraph_info():
    print('Directory: ' + os.path.dirname(os.path.realpath(__file__)))
    print('iGraph version: ' + igraph.__version__)

print_igraph_info()

f = open('graphs/datascience.stackoverflow.com.gml', 'r')
g = igraph.Graph.Read_GML(f)

def print_graph_info(graph):
    print("Edges (Answers/Comments): ", graph.ecount())
    print("Nodes (Posts): ", graph.vcount())
    print("Avg in-degree (Answers per Post): ", numpy.mean(graph.indegree()))
    print("Avg out-degree (Answers per User): ", numpy.mean(graph.outdegree()))
    
    degreeOne = [degree for degree in graph.degree() if degree == 0];
    print("Isolated nodes (Posts without Answer/Comment): ", len(degreeOne), " (", len(degreeOne)/graph.vcount()*100, "%)")

print_graph_info(g)

def print_connected_components(graph):
    components = graph.components('WEAK');
    print("Connected components: ", len(components))
    print("Giant component: ", components.giant().vcount(), " (", components.giant().vcount()/graph.vcount()*100, "%)")
    
print_connected_components(g)