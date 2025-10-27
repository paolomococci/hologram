// This package contains all the necessary components to create an HTTP server that interacts with a PostgreSQL database.
package main

import (

	/*
		"database/sql" provides the SQL database interface.
		"encoding/json" allows JSON encoding and decoding.
		"log" is used for logging errors and messages.
		"net/http" handles HTTP server operations.
		"strings" provides string manipulation functions.
		_ "github.com/lib/pq" is the PostgreSQL driver for Go.
	*/

	"database/sql"
	"encoding/json"
	"log"
	"net/http"
	"strings"

	_ "github.com/lib/pq"
)

// Guest struct represents a guest with fields ID, Name, Email, and Role.
type Guest struct {
	ID    sql.NullString `json:"id"`
	Name  sql.NullString `json:"name"`
	Email sql.NullString `json:"email"`
	Role  sql.NullString `json:"role"`
}

var db *sql.DB

// main function initializes the database connection and sets up the HTTP server.
func main() {
	// Connection string for PostgreSQL. Replace with your actual connection details.
	connStr := "postgres://postgres:qwerty123@127.0.0.1:5432/guests_db?sslmode=disable"

	var err error
	db, err = sql.Open("postgres", connStr)
	if err != nil {
		// Fatal logs and exits if database connection fails.
		log.Fatalf("failed to open db: %v", err)
	}
	// Ensures the database connection is closed when main exits.
	defer db.Close()

	// Pings the database to check connectivity.
	if err = db.Ping(); err != nil {
		// Fatal logs and exits if database ping fails.
		log.Fatalf("failed to ping db: %v", err)
	}

	// Register CORS middleware and
	// sets up HTTP routes for guestsHandler and guestByEmailHandler.
	http.Handle("/guests", corsMiddleware(http.HandlerFunc(guestsHandler)))
	http.Handle("/guests/", corsMiddleware(http.HandlerFunc(guestByEmailHandler)))

	// Logs that the server is running on port 8080.
	log.Println("server listening on :8080")
	if err := http.ListenAndServe(":8080", nil); err != nil {
		// Fatal logs and exits if server startup fails.
		log.Fatalf("server error: %v", err)
	}
}

// guestsHandler handles GET requests to /guests and returns all guests in JSON format.
func guestsHandler(w http.ResponseWriter, r *http.Request) {
	// Checks if the request method is GET. If not, returns a 405 Method Not Allowed response.
	if r.Method != http.MethodGet {
		http.Error(w, "method not allowed", http.StatusMethodNotAllowed)
		return
	}

	// Executes a query to fetch all guests from the database.
	rows, err := db.Query("select id, name, email, role from guests_sc.guests")
	if err != nil {
		// Returns an internal server error if the query fails.
		http.Error(w, "db query error", http.StatusInternalServerError)
		return
	}
	// Closes the rows when done to free resources.
	defer rows.Close()

	var guests []Guest
	// Iterates over each row returned by the database query.
	for rows.Next() {
		var g Guest
		if err := rows.Scan(&g.ID, &g.Name, &g.Email, &g.Role); err != nil {
			// Returns an internal server error if scanning fails.
			http.Error(w, "db scan error", http.StatusInternalServerError)
			return
		}
		// Appends each guest to the guests slice.
		guests = append(guests, g)
	}

	// Checks for any errors that may have occurred during iteration.
	if err := rows.Err(); err != nil {
		http.Error(w, "rows error", http.StatusInternalServerError)
		return
	}

	// Writes the JSON response back to the client.
	writeJSON(w, guests)
}

// guestByEmailHandler handles GET requests to /guests/{email} and returns a specific guest by email in JSON format.
func guestByEmailHandler(w http.ResponseWriter, r *http.Request) {
	// Checks if the request method is GET. If not, returns a 405 Method Not Allowed response.
	if r.Method != http.MethodGet {
		http.Error(w, "method not allowed", http.StatusMethodNotAllowed)
		return
	}

	// Extracts the email from the URL path.
	email := strings.Trim(r.URL.Path[len("/guests/"):], "/")

	// Checks if the email is empty. If so, returns a 404 Not Found response.
	if email == "" {
		http.NotFound(w, r)
		return
	}

	var g Guest
	// Executes a query to fetch a specific guest by email.
	err := db.QueryRow("SELECT id, name, email, role FROM guests_sc.guests WHERE email = $1", email).Scan(&g.ID, &g.Name, &g.Email, &g.Role)
	// Checks if no rows were found (email not exists).
	if err == sql.ErrNoRows {
		// Returns a 404 Not Found response.
		http.NotFound(w, r)
		return
	}
	// Checks for any other errors during query execution.
	if err != nil {
		// Returns an internal server error.
		http.Error(w, "db query error", http.StatusInternalServerError)
		return
	}

	// Writes the JSON response back to the client.
	writeJSON(w, g)
}

// writeJSON function writes a JSON response to the client.
func writeJSON(w http.ResponseWriter, v any) {
	// Sets the content type header to application/json.
	w.Header().Set("Content-Type", "application/json")
	// Creates a new JSON encoder for the response writer.
	enc := json.NewEncoder(w)
	// Encodes the value (guests or guest) into JSON and writes it to the client.
	if err := enc.Encode(v); err != nil {
		// Returns an internal server error if encoding fails.
		http.Error(w, "encode error", http.StatusInternalServerError)
	}
}

// The corsMiddleware function handles CORS requests.
func corsMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		// Preflight Request Management (OPTIONS).
		if r.Method == http.MethodOptions {
			w.Header().Set("Access-Control-Allow-Origin", "*")
			w.Header().Set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
			w.Header().Set("Access-Control-Allow-Headers", "Content-Type, Authorization")
			w.WriteHeader(http.StatusOK)
			return
		}

		// Handling normal requests
		w.Header().Set("Access-Control-Allow-Origin", "*")

		next.ServeHTTP(w, r)
	})
}
