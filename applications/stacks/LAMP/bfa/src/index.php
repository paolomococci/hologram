<?php
declare (strict_types = 1);

// Bellman-Ford API: accepts POST with JSON body (Content-Type: application/json)
// Always returns JSON. Validates input strictly.

// Send JSON response and exit
function jsonResponse(array $data, int $status = 200): void
{
    // Set HTTP response code
    http_response_code($status);
    // Set Content-Type header to application/json with UTF-8 charset
    header('Content-Type: application/json; charset=utf-8');
    // Encode data array as JSON and print it
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    // Exit the script after sending response
    exit;
}

// Ensure POST method is used
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Respond with error if method is not POST
    jsonResponse(['error' => 'Method Not Allowed. Use POST with Content-Type: application/json.'], 405);
}

// Ensure Content-Type header specifies application/json (allow charset)
$contentType = $_SERVER['CONTENT_TYPE'] ?? ($_SERVER['HTTP_CONTENT_TYPE'] ?? '');
if (stripos($contentType, 'application/json') !== 0) {
    // Respond with error if Content-Type is not application/json
    jsonResponse(['error' => 'Invalid Content-Type. Expect application/json.'], 415);
}

// Read raw request body from php://input
$raw = file_get_contents('php://input');
if ($raw === false || trim($raw) === '') {
    // Respond with error if the request body is empty or invalid
    jsonResponse(['error' => 'Empty request body. Provide valid JSON.'], 400);
}

// Decode raw JSON string to associative array
$payload = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE || ! is_array($payload)) {
    // Respond with error if decoding fails or result is not an array
    jsonResponse(['error' => 'Invalid JSON: ' . json_last_error_msg()], 400);
}

// Validate required fields in the JSON payload
if (! array_key_exists('nodes', $payload) || ! array_key_exists('edges', $payload) || ! array_key_exists('source', $payload)) {
    // Respond with error if any of the required keys are missing
    jsonResponse(['error' => 'Missing required fields. Expect keys: nodes, edges, source.'], 400);
}

// Extract nodes from payload
$nodes  = $payload['nodes'];
$edges  = $payload['edges'];
$source = $payload['source'];

// Validate nodes from payload
if (! is_array($nodes) || count($nodes) === 0) {
    // Respond with error if nodes is not a non-empty array of string labels
    jsonResponse(['error' => 'Invalid "nodes": must be a non-empty array of unique string labels.'], 400);
}
if (! is_array($edges)) {
    // Respond with error if edges is not an array
    jsonResponse(['error' => 'Invalid "edges": must be an array of [from,to,weight] entries.'], 400);
}
if (! is_string($source) || $source === '') {
    // Respond with error if source is not a non-empty string label
    jsonResponse(['error' => 'Invalid "source": must be a non-empty string matching one of the node labels.'], 400);
}

// Normalize nodes: ensure they are strings and unique, build index mapping
$labels = [];
$index  = [];
foreach ($nodes as $i => $label) {
    if (! is_string($label) || $label === '') {
        // Respond with error if any node label is not a non-empty string
        jsonResponse(['error' => "Invalid node label at index $i: labels must be non-empty strings."], 400);
    }
    if (isset($index[$label])) {
        // Respond with error if duplicate node label is found
        jsonResponse(['error' => "Duplicate node label: $label"], 400);
    }
    // Map label to index
    $index[$label] = count($labels);
    // Store unique labels
    $labels[] = $label;
}
$n = count($labels);

// Verify that the source node exists in the nodes list
if (! isset($index[$source])) {
    jsonResponse(['error' => 'Source node not found in nodes list.'], 400);
}

// Validate edges and build internal edge list with index mappings
$edgeList = [];
foreach ($edges as $ei => $e) {
    if (! is_array($e) || count($e) < 3) {
        jsonResponse(['error' => "Invalid edge at index $ei: each edge must be an array [from, to, weight]."], 400);
    }
    [$uLabel, $vLabel, $w] = $e;

    if (! is_string($uLabel) || $uLabel === '' || ! is_string($vLabel) || $vLabel === '') {
        // Respond with error if any edge node label is not a non-empty string
        jsonResponse(['error' => "Invalid edge nodes at index $ei: from/to must be non-empty strings."], 400);
    }
    if (! isset($index[$uLabel]) || ! isset($index[$vLabel])) {
        // Respond with error if any edge references unknown node(s)
        jsonResponse(['error' => "Edge at index $ei references unknown node(s): $uLabel or $vLabel not in nodes list."], 400);
    }
    if (! is_int($w) && ! is_float($w) && ! is_numeric($w)) {
        // Respond with error if edge weight is not numeric
        jsonResponse(['error' => "Invalid weight at edge index $ei: weight must be numeric."], 400);
    }
    // Convert weight to float
    $weight = floatval($w);
    // Store indexed edge with weights
    $edgeList[] = [$index[$uLabel], $index[$vLabel], $weight];
}

// Bellman-Ford algorithm implementation function
function bellmanFord(int $n, array $edges, int $source): array
{
    // Initialize distances to infinity
    $INF = INF;
    // Set source distance to 0.0
    $dist = array_fill(0, $n, $INF);
    // Predecessors initialized to null
    $pred = array_fill(0, $n, null);
    //
    $dist[$source] = 0.0;

    // Relax edges up to n-1 times with early exit if no change occurs
    for ($i = 1; $i <= max(0, $n - 1); $i++) {
        $changed = false;
        foreach ($edges as [$u, $v, $w]) {
            // Relaxation step: update distance and predecessor if shorter path is found
            if ($dist[$u] !== $INF && $dist[$u] + $w < $dist[$v]) {
                $dist[$v] = $dist[$u] + $w;
                $pred[$v] = $u;
                // Mark change to avoid unnecessary iterations
                $changed = true;
            }
        }
        // Early exit if no changes occur in this iteration
        if (! $changed) {
            break;
        }

    }

    // Detect negative cycles reachable from source node
    $hasNegativeCycle = false;
    foreach ($edges as [$u, $v, $w]) {
        if ($dist[$u] !== $INF && $dist[$u] + $w < $dist[$v]) {
            // Negative cycle detected
            $hasNegativeCycle = true;
            break;
        }
    }

    return ['dist' => $dist, 'pred' => $pred, 'negative_cycle' => $hasNegativeCycle];
}

// Execute Bellman-Ford algorithm with given parameters
$res = bellmanFord($n, $edgeList, $index[$source]);

// Convert results back to labels and build paths for each node
// Initialize an array to store distances
$distances = [];
// Initialize an array to store predecessors
$predecessors = [];
// Initialize an array to store paths
$paths = [];
// Initialize an array to store short paths
$short_paths = [];

// Loop through each node
for ($i = 0; $i < $n; $i++) {
    // Get the label of the current node
    $label = $labels[$i];
    // Get the distance from source to this node
    $d = $res['dist'][$i];
    // Store distance or null if infinite
    $distances[$label] = is_infinite($d) ? null : $d;
    // Get index of predecessor
    $predIdx = $res['pred'][$i];
    // Map predecessor index to label
    $predecessors[$label] = $predIdx === null ? null : $labels[$predIdx];

    // Reconstruct path if reachable
    // If the node is unreachable
    if (is_infinite($d)) {
        // Set path to null
        $paths[$label] = null;
        // Set short path to null
        $short_paths[$label] = null;
    } else {
        // Initialize an array for storing the path
        $path = [];
        // Start from current node
        $cur = $i;
        // While there's a predecessor
        while ($cur !== null) {
            // Build path from predecessors
            // Add current label to the beginning of the path
            array_unshift($path, $labels[$cur]);
            // Move to the previous node
            $cur = $res['pred'][$cur];
        }
        // If path is empty or doesn't start with source
        if (empty($path) || $path[0] !== $source) {
            // Set path to null
            $paths[$label] = null;
            // Set short path to null
            $short_paths[$label] = null;
        } else {
            // Only keep the nodes that are part of the actual path
            // Store unique nodes in the path
            $paths[$label] = array_values(array_unique($path));
            // Short paths array
            $short_paths[$label] = [
                // Include the path
                'path' => $paths[$label],
                // Include distance as cost
                'cost' => $distances[$label],
            ];
        }
    }
}

// Send final JSON response with computed results
jsonResponse([
    // Distances from source to each node
    'distances'      => $distances,
    // Predecessors for each node
    'predecessors'   => $predecessors,
    // Paths from source to each node
    'paths'          => $paths,
    // Short paths with costs
    'short_paths'    => $short_paths,
    // Flag indicating if there's a negative cycle
    'negative_cycle' => $res['negative_cycle'],
    'meta'           => [
        // Number of nodes in the graph
        'node_count' => $n,
        // Number of edges in the graph
        'edge_count' => count($edgeList),
        // Source node for path calculations
        'source'     => $source,
    ],
], 200);
