<?php

if (!function_exists('assert')) {
    /**
     * Assert fuctions.
     *
     * @param bool $bool
     * @param string $message
     * @throws Exception
     */
    function assert($bool, $message = NULL) {
        if (!$bool) {
            throw new Exception($message);
        }
    }
}

/**
 * Class Graph represents an undirected or directed weighted graph. The edges are
 * stored in the form of an adjacency matrix. Each node can have arbitrary
 * attributes. Unweighted graphs have weight = 1 per default.
 *
 * @author David Stutz
 */
class Graph {

    /**
     * Array of nodes with corresponding attributes.
     */
    protected $_nodes;

    /**
     * Adjacency matrix.
     */
    protected $_edges;

    /**
     * Directed graph flag.
     */
    protected $_directed;

    /**
     * Construct a graph by an array of nodes, edges and set the graph directed
     * or undirected (this cannot be changed afterwards).
     *
     * @param array $nodes
     * @param array $edges
     * @param bool $directed
     */
    public function __construct($nodes = array(), $edges = array(), $directed = TRUE) {
        $this->_nodes = $nodes;
        $this->_edges = $edges;

        assert($directed === TRUE OR $directed === FALSE);
        $this->_directed = $directed;
    }

    /**
     * Add an directed edge $idA -> $idB, or the corresponding undirected edge
     * witht he given weight (default is 1 for unweighted graphs).
     *
     * @param mixed $idA
     * @param mixed $idB
     * @param double $weight
     */
    public function addEdge($idA, $idB, $weight = 1) {

        assert(!is_array($weight) AND !is_object($weight));

        assert(FALSE !== array_key_exists($idA, $this->_edges));
        assert(FALSE !== array_key_exists($idB, $this->_edges[$idA]));
        assert(FALSE !== array_key_exists($idB, $this->_edges));
        assert(sizeof($this->_edges) == $this->numNodes());
        assert(sizeof($this->_edges[$idA]) == $this->numNodes());
        assert(sizeof($this->_edges[$idB]) == $this->numNodes());

        $this->_edges[$idA][$idB] = (double) $weight;

        if ($this->_directed === FALSE) {
            assert(FALSE !== array_key_exists($idA, $this->_edges[$idB]));
            $this->_edges[$idB][$idA] = (double) $weight;
        }
    }

    /**
     * Add a node with the given id and array of attributes.
     *
     * @param mixed $id
     * @param array $array
     */
    public function addNode($id, $array) {

        assert(FALSE === array_key_exists($id, $this->_nodes));
        assert(FALSE === array_key_exists($id, $this->_edges));

        $this->_nodes[$id] = $array;
        $this->_edges[$id] = array();

        foreach ($this->_nodes as $nodeId => $array) {
            assert(FALSE !== array_key_exists($nodeId, $this->_edges));
            assert(FALSE !== array_key_exists($id, $this->_edges));

            assert(FALSE === array_key_exists($id, $this->_edges[$nodeId]));
            assert(FALSE === array_key_exists($id, $this->_edges[$nodeId]));

            $this->_edges[$nodeId][$id] = 0;
            assert(sizeof($this->_edges[$nodeId]) == $this->numNodes());

            $this->_edges[$id][$nodeId] = 0;
        }

        assert(count($this->_edges, 0) == $this->numNodes());
    }

    /**
     * Get the number of nodes.
     *
     * @return int
     */
    public function numNodes() {
        return count($this->_nodes, 0);
    }

    /**
     * Check whether a node with the given id extists.
     *
     * @param mixed $id
     * @return bool
     */
    public function nodeExists($id) {
        return array_key_exists($id, $this->_nodes);
    }

    /**
     * Export graph as GML file.
     *
     * @return string
     */
    public function exportasGML() {
        $return = 'graph [' . "\n";
        $return .= "\t" . 'directed ' . ($this->_directed === TRUE ? '1': '0') . "\n";

        foreach ($this->_nodes as $id => $array) {
            $return .= "\t" . 'node [' . "\n"
                    . "\t\t" . 'id ' . $id . "\n";

            foreach ($array as $key => $value) {
                $escapedValue = $value;
                if (!is_numeric($escapedValue)) {
                    $escapedValue = '"' . $escapedValue . '"';
                }

                $return .= "\t\t" . $key . ' ' . $escapedValue . "\n";
            }

            $return .= "\t" . ']' . "\n";
        }

        foreach ($this->_edges as $idA => $array) {
            foreach ($this->_edges[$idA] as $idB => $weight) {
                if ($weight != 0) {
                    $return .= "\t" . 'edge [' . "\n"
                            . "\t\t" . 'source ' . $idA . "\n"
                            . "\t\t" . 'target ' . $idB . "\n"
                            . "\t\t" . 'weight ' . $weight . "\n"
                            . "\t" . ']' . "\n";
                }
            }
        }

        $return .= ']';

        return $return;
    }
}
