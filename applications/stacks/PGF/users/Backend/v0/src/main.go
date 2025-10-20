package main

import (
	"encoding/json"
	"fmt"
	"net/http"
)

// Response defines the JSON structure returned to clients,
// using a struct ensures the output is well-formed and easy to extend.
type response struct {
	Message string `json:"message"`
}

func main() {
	// Register the handler function for the root path ("/").
	// http.HandleFunc wires the route to our hello function.
	http.HandleFunc("/", hello)

	// Start an HTTP server listening on port 8080,
	// ListenAndServe blocks, if it returns an error, log it to stdout.
	if err := http.ListenAndServe(":8080", nil); err != nil {
		// Print a short, human-readable error message if the server fails to start.
		fmt.Println("Server error:", err)
	}
}

// hello is the HTTP handler for the root path,
// it writes a JSON response with the greeting message.
func hello(w http.ResponseWriter, r *http.Request) {
	// Set the Content-Type header so clients know the response is JSON and
	// adding the charset is good practice for text encodings.
	w.Header().Set("Content-Type", "application/json; charset=utf-8")

	// Prepare the response payload.
	resp := response{Message: "Greetings from the wonderful world of Go!"}

	// Encode the response as JSON and write it to the ResponseWriter.
	// json.NewEncoder(w).Encode writes the JSON and a trailing newline.
	// If encoding fails (very unlikely for this simple struct), return a 500 error.
	if err := json.NewEncoder(w).Encode(resp); err != nil {
		// If encoding fails, write a minimal JSON error body with an appropriate status.
		// http.Error sets the Content-Type to "text/plain; charset=utf-8" by default,
		// so we write the JSON string explicitly to keep the response consistent.
		http.Error(w, `{"message":"internal error"}`, http.StatusInternalServerError)
	}
}
