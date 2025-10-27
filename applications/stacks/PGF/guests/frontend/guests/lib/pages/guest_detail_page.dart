import 'package:flutter/material.dart';
import 'package:guests/models/guest.dart';

/// Screen that displays all details for a single guest.
/// The Guest instance is passed via the `arguments` of the Navigator.
class GuestDetailPage extends StatelessWidget {
  const GuestDetailPage({super.key});

  // Helper to build a labeled text row.
  Widget _buildDetailRow(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 4.0),
      child: Row(
        children: [
          Text('$label: ', style: const TextStyle(fontWeight: FontWeight.bold)),
          Expanded(child: Text(value)),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    // Retrieve the Guest object passed from the previous screen.
    final Guest guest = ModalRoute.of(context)!.settings.arguments as Guest;

    return Scaffold(
      appBar: AppBar(title: const Text('Guest Details')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Build each detail row with the corresponding guest details.
            _buildDetailRow('ID', guest.id),
            _buildDetailRow('Name', guest.name),
            _buildDetailRow('Email', guest.email),
            _buildDetailRow('Role', guest.role),
          ],
        ),
      ),
    );
  }
}
