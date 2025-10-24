// This package contains all the necessary components to create an HTTP server that interacts with a PostgreSQL database.

package main

/*
	"database/sql" provides the SQL database interface.
	"encoding/json" allows JSON encoding and decoding.
	"log" is used for logging errors and messages.
	"net/http" handles HTTP server operations.
	"strings" provides string manipulation functions.
	_ "github.com/lib/pq" is the PostgreSQL driver for Go.
*/

import (
	"database/sql"
	"encoding/json"
	"log"
	"net/http"
	"strings"

	_ "github.com/lib/pq"
)

// User struct represents a user with fields ID, Name, Email, and Role.
type User struct {
	ID    sql.NullString `json:"id"`
	Name  sql.NullString `json:"name"`
	Email sql.NullString `json:"email"`
	Role  sql.NullString `json:"role"`
}

var db *sql.DB

// main function initializes the database connection and sets up the HTTP server.
func main() {
	// Connection string for PostgreSQL. Replace with your actual connection details.
	connStr := "postgres://postgres:secure_password@127.0.0.1:5432/users_db?sslmode=disable"

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

	// Sets up HTTP routes for usersHandler and userByEmailHandler.
	http.HandleFunc("/users", usersHandler)
	http.HandleFunc("/users/", userByEmailHandler) // /users/{email}

	// Logs that the server is running on port 8080.
	log.Println("server listening on :8080")
	if err := http.ListenAndServe(":8080", nil); err != nil {
		// Fatal logs and exits if server startup fails.
		log.Fatalf("server error: %v", err)
	}
}

// usersHandler handles GET requests to /users and returns all users in JSON format.
func usersHandler(w http.ResponseWriter, r *http.Request) {
	// Checks if the request method is GET. If not, returns a 405 Method Not Allowed response.
	if r.Method != http.MethodGet {
		http.Error(w, "method not allowed", http.StatusMethodNotAllowed)
		return
	}

	// Executes a query to fetch all users from the database.
	rows, err := db.Query("select id, name, email, role from users_sc.users")
	if err != nil {
		// Returns an internal server error if the query fails.
		http.Error(w, "db query error", http.StatusInternalServerError)
		return
	}
	// Closes the rows when done to free resources.
	defer rows.Close()

	var users []User
	// Iterates over each row returned by the database query.
	for rows.Next() {
		var u User
		if err := rows.Scan(&u.ID, &u.Name, &u.Email, &u.Role); err != nil {
			// Returns an internal server error if scanning fails.
			http.Error(w, "db scan error", http.StatusInternalServerError)
			return
		}
		// Appends each user to the users slice.
		users = append(users, u)
	}
	// Checks for any errors that may have occurred during iteration.
	if err := rows.Err(); err != nil {
		http.Error(w, "rows error", http.StatusInternalServerError)
		return
	}

	// Writes the JSON response back to the client.
	writeJSON(w, users)
}

// userByEmailHandler handles GET requests to /users/{email} and returns a specific user by email in JSON format.
func userByEmailHandler(w http.ResponseWriter, r *http.Request) {
	// Checks if the request method is GET. If not, returns a 405 Method Not Allowed response.
	if r.Method != http.MethodGet {
		http.Error(w, "method not allowed", http.StatusMethodNotAllowed)
		return
	}

	// Extracts the email from the URL path.
	email := strings.Trim(r.URL.Path[len("/users/"):], "/")

	// Checks if the email is empty. If so, returns a 404 Not Found response.
	if email == "" {
		http.NotFound(w, r)
		return
	}

	var u User
	// Executes a query to fetch a specific user by email.
	err := db.QueryRow("SELECT id, name, email, role FROM users_sc.users WHERE email = $1", email).Scan(&u.ID, &u.Name, &u.Email, &u.Role)
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
	writeJSON(w, u)
}

// writeJSON function writes a JSON response to the client.
func writeJSON(w http.ResponseWriter, v any) {
	// Sets the content type header to application/json.
	w.Header().Set("Content-Type", "application/json")
	// Creates a new JSON encoder for the response writer.
	enc := json.NewEncoder(w)
	// Encodes the value (users or user) into JSON and writes it to the client.
	if err := enc.Encode(v); err != nil {
		// Returns an internal server error if encoding fails.
		http.Error(w, "encode error", http.StatusInternalServerError)
	}
}
