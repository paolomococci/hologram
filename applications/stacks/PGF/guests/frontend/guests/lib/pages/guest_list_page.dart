import 'package:flutter/material.dart';
import 'package:guests/models/guest.dart';
import 'package:guests/services/guest_api_service.dart';

/// The main screen that shows a scrollable list of all guests.
/// It also contains a search bar that lets the user look up a guest by
/// their email address and navigate directly to the detail screen.
class GuestListPage extends StatefulWidget {
  const GuestListPage({super.key});

  @override
  State<GuestListPage> createState() => _GuestListPageState();
}

class _GuestListPageState extends State<GuestListPage> {
  final GuestApiService _apiService = GuestApiService();
  final TextEditingController _searchController = TextEditingController();
  late Future<List<Guest>> _guestsFuture;

  @override
  void initState() {
    super.initState();
    // Kick off the network request immediately.
    _guestsFuture = _apiService.fetchGuests();
  }

  /// Triggered when the user taps the “Search” button.
  /// Looks up a guest by the email entered in the search field.
  /// On success, navigates to the detail screen; on failure, shows a SnackBar.
  Future<void> _searchGuest() async {
    final email = _searchController.text.trim();
    if (email.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Please enter an email address')),
      );
      return;
    }

    try {
      final guest = await _apiService.fetchGuestByEmail(email);
      // Check if the widget is still mounted
      if (!mounted) return;
      Navigator.pushNamed(context, '/detail', arguments: guest);
    } catch (e) {
      // Check if the widget is still mounted
      if (!mounted) return;
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text(e.toString())));
    }
  }

  /// Builds the UI for each list item.
  Widget _buildGuestTile(Guest guest) {
    return ListTile(
      leading: const Icon(Icons.person),
      title: Text(guest.name),
      subtitle: Text(guest.email),
      trailing: Text(guest.role),
      onTap: () {
        // Pass the Guest object as an argument to the detail screen.
        Navigator.pushNamed(context, '/detail', arguments: guest);
      },
    );
  }

  /// Builds the search bar UI.
  Widget _buildSearchBar() {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Row(
        children: [
          // Expanded so the TextField takes the remaining space.
          Expanded(
            child: TextField(
              controller: _searchController,
              decoration: const InputDecoration(
                labelText: 'Search by email',
                border: OutlineInputBorder(),
              ),
              onSubmitted: (_) => _searchGuest(),
            ),
          ),
          const SizedBox(width: 8),
          ElevatedButton(onPressed: _searchGuest, child: const Text('Search')),
        ],
      ),
    );
  }

  /// Main build method that uses a FutureBuilder to handle async data.
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Guest Roll')),
      body: Column(
        children: [
          _buildSearchBar(),
          // Expanded so the list occupies the remaining vertical space.
          Expanded(
            child: FutureBuilder<List<Guest>>(
              future: _guestsFuture,
              builder: (context, snapshot) {
                // While waiting for data, show a loading spinner.
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Center(child: CircularProgressIndicator());
                }

                // If an error occurred, show the message and a retry button.
                if (snapshot.hasError) {
                  return Center(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Text(
                          'Error: ${snapshot.error}',
                          textAlign: TextAlign.center,
                          style: const TextStyle(color: Colors.red),
                        ),
                        const SizedBox(height: 16),
                        ElevatedButton(
                          onPressed: () {
                            setState(() {
                              _guestsFuture = _apiService.fetchGuests();
                            });
                          },
                          child: const Text('Retry'),
                        ),
                      ],
                    ),
                  );
                }

                // When data is ready, show it in a ListView.
                final guests = snapshot.data!;
                return ListView.separated(
                  itemCount: guests.length,
                  separatorBuilder: (_, __) => const Divider(height: 1),
                  itemBuilder: (_, index) => _buildGuestTile(guests[index]),
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}
