<?php

include 'Graph.php';

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
 * Creates a graph where each user is a node and nodes are connected in the
 * following way:
 *
 *  user A -> user B iff A comments a post from B
 *
 * Edge weights correspond to the comment score. Additional attributes saved
 * for users are:
 *
 *  - Reputation
 *  - DisplayName
 *  - Views
 *  - UpVotes
 *  - DownVotes
 *
 * The unique identifier of every user is its respective id.
 *
 * Usage:
 *
 *  $postsFile = 'Posts.xml';
 *  $commentsFile = 'Comments.xml';
 *  $usersFile = 'Users.xml';
 *
 *  $userPostCommentGraph = new UserPostCommentGraph($postsFile, $commentsFile, $usersFile);
 *  // Creates the graph ...
 *  $userPostCommentGraph->process();
 *  // Gets the created graph, see the Graph class.
 *  $graph = $userPostCommentGraph->getGraph();
 *
 * @author David Stutz
 */
class UserPostCommentGraph {

    /**
     * The created graph.
     */
    protected $_graph;

    /**
     * XML of posts as string.
     */
    protected $_postsXML;

    /**
     * XML of comments as string.
     */
    protected $_commentsXML;

    /**
     * XML of users as string.
     */
    protected $_usersXML;

    /**
     * Construct a graph by providing Posts.xml, Comments.xml, Users.xml.
     *
     * @param string $postsFile
     * @param string $commentsFile
     * @param string $usersFile
     */
    public function __construct($postsFile, $commentsFile, $usersFile) {
        assert(file_exists($postsFile));
        assert(file_exists($commentsFile));
        assert(file_exists($usersFile));

        $postsXML = new XMLReader();
        $postsXML->open($postsFile);
        $postsXML->setParserProperty(XMLReader::VALIDATE, true);
        assert($postsXML->isValid());

        $commentsXML = new XMLReader();
        $commentsXML->open($commentsFile);
        $commentsXML->setParserProperty(XMLReader::VALIDATE, true);
        assert($commentsXML->isValid());

        $usersXML = new XMLReader();
        $usersXML->open($usersFile);
        $usersXML->setParserProperty(XMLReader::VALIDATE, true);
        assert($usersXML->isValid());

        $this->_postsXML = file_get_contents($postsFile);
        $this->_commentsXML = file_get_contents($commentsFile);
        $this->_usersXML = file_get_contents($usersFile);

        $this->_graph = NULL;
    }

    /**
     * Processes the XML files and sets up the actual graph.
     *
     * Use
     *
     *  $userPostCommentGraph->getGraph()
     *
     * to get the created graph (see Graph class).
     */
    public function process() {
        $postsXMLElement = new SimpleXMLElement($this->_postsXML);
        $commentsXMLElement = new SimpleXMLElement($this->_commentsXML);
        $usersXMLElement = new SimpleXMLElement($this->_usersXML);

        $this->_graph = new Graph();
        foreach ($postsXMLElement->row as $post) {
            $userPostId = (string) $post['OwnerUserId'];
            $postId = (string) $post['Id'];

            $userPost = $usersXMLElement->xpath('/users/row[@Id="' . $userPostId . '"]');

            if (sizeof($userPost) > 0) {
                $userPost = $userPost[0];

                if (!$this->_graph->nodeExists($userPostId)) {
                    $this->_graph->addNode($userPostId, array(
                        'Reputation' => (string) $userPost['Reputation'],
                        'DisplayName' => (string) $userPost['DisplayName'],
                        'Views' => (string) $userPost['Views'],
                        'UpVotes' => (string) $userPost['UpVotes'],
                        'DownVotes' => (string) $userPost['DownVotes'],
                    ));
                }

                foreach ($commentsXMLElement->xpath('/comments/row[@PostId="' . $postId . '"]') as $comment) {

                    $userCommentId  = (string) $comment['UserId'];
                    $userComment = $usersXMLElement->xpath('/users/row[@Id="' . $userCommentId . '"]');

                    if (sizeof($userComment) > 0) {
                        $userComment = $userComment[0];

                        if (!$this->_graph->nodeExists($userCommentId)) {
                            $this->_graph->addNode($userCommentId, array(
                                'Reputation' => (string) $userComment['Reputation'],
                                'DisplayName' => (string) $userComment['DisplayName'],
                                'Views' => (string) $userComment['Views'],
                                'UpVotes' => (string) $userComment['UpVotes'],
                                'DownVotes' => (string) $userComment['DownVotes'],
                            ));
                        }

                        assert(TRUE === $this->_graph->nodeExists($userCommentId));
                        assert(TRUE === $this->_graph->nodeExists($userPostId));

                        $this->_graph->addEdge($userCommentId, $userPostId, (int) $comment['Score']);
                    }
                }
            }
        }
    }

    /**
     * Get the created graph.
     *
     * @return Graph
     */
    public function getGraph() {
        assert($this->_graph !== NULL);

        return $this->_graph;
    }
}

$userPostCommentGraph = new UserPostCommentGraph('../data/raspberrypi.stackexchange.com/Posts.xml', '../data/raspberrypi.stackexchange.com/Comments.xml', '../data/raspberrypi.stackexchange.com/Users.xml');
$userPostCommentGraph->process();

ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 600);

header('Content-type: text/gml');
echo $userPostCommentGraph->getGraph()->exportAsGML();
