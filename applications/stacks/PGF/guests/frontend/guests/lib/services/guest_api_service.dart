import 'dart:convert';
import 'package:http/http.dart' as http;

import '../models/guest.dart';

/// Service that wraps all HTTP calls to the guest API.
/// The base URL is hard‑coded here, but you could expose it via
/// an environment variable or a `Config` class if you wish.
class GuestApiService {
  // Replace with the actual host where the API is running.
  static const String _baseUrl = 'http://192.168.XXX.XXX:8080';

  /// Fetches the complete list of guests.
  Future<List<Guest>> fetchGuests() async {
    final uri = Uri.parse('$_baseUrl/guests');
    final response = await http.get(uri);

    if (response.statusCode == 200) {
      // The API returns a JSON array of guest objects.
      final List<dynamic> data = jsonDecode(response.body);
      return Guest.listFromJson(data);
    } else {
      throw Exception(
        'Failed to load guests: ${response.statusCode} ${response.reasonPhrase}',
      );
    }
  }

  /// Fetches a single guest identified by the email address.
  /// The email is URL‑encoded to avoid any malformed requests.
  Future<Guest> fetchGuestByEmail(String email) async {
    final encodedEmail = Uri.encodeFull(email);
    final uri = Uri.parse('$_baseUrl/guests/$encodedEmail');
    final response = await http.get(uri);

    if (response.statusCode == 200) {
      final Map<String, dynamic> data = jsonDecode(response.body);
      return Guest.fromJson(data);
    } else if (response.statusCode == 404) {
      throw Exception('Guest not found');
    } else {
      throw Exception(
        'Failed to load guest: ${response.statusCode} ${response.reasonPhrase}',
      );
    }
  }
}
