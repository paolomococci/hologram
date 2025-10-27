import 'dart:convert';

// The Guest model represents a single guest returned by the API.
// The API returns each field as an object with a `String` and a `Valid` flag
// (e.g. {"String":"jake@example.local","Valid":true}).
// This model extracts the actual string values for easier usage.
class Guest {
  final String id;
  final String name;
  final String email;
  final String role;

  // Constructor for the Guest class, requiring all fields to be initialized.
  const Guest({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
  });

  /// Creates a Guest instance from the nested JSON format.
  factory Guest.fromJson(Map<String, dynamic> json) {
    // Extracting string values for each field using the _extractString helper function.
    return Guest(
      id: _extractString(json['id']),
      name: _extractString(json['name']),
      email: _extractString(json['email']),
      role: _extractString(json['role']),
    );
  }

  /// Helper that pulls the "String" value out of the API’s custom wrapper.
  static String _extractString(dynamic field) {
    // If the field is null, return an empty string.
    if (field == null) return '';
    // If the field is a Map and contains a 'String' key with a non-null value,
    // return that value as a String.
    if (field is Map<String, dynamic> && field['String'] != null) {
      return field['String'] as String;
    }
    // Otherwise, convert the field to a string using the default toString method.
    return field.toString();
  }

  // ignore: unintended_html_in_doc_comment
  /// Utility to convert a list of JSON objects into a List<Guest>.
  static List<Guest> listFromJson(List<dynamic> jsonList) {
    // Using map to transform each JSON object in the list into a Guest instance.
    return jsonList.map((json) => Guest.fromJson(json)).toList();
  }

  /// Pretty‑printed JSON (for debugging, if needed)
  @override
  String toString() => jsonEncode(toJson());

  // Method that converts this Guest instance back into a JSON object.
  Map<String, dynamic> toJson() => {
    'id': id,
    'name': name,
    'email': email,
    'role': role,
  };
}
