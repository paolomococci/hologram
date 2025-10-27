import 'package:flutter/material.dart';
import 'package:guests/pages/guest_detail_page.dart';
import 'package:guests/pages/guest_list_page.dart';

class GuestWidget extends StatelessWidget {
  const GuestWidget({super.key});

  @override
  Widget build(BuildContext context) {
    // MaterialApp provides Material Design styling.
    return MaterialApp(
      title: 'Guest Roll',
      theme: ThemeData(primarySwatch: Colors.blue),
      // Define all named routes used in the app.
      routes: {
        '/': (context) => const GuestListPage(),
        '/detail': (context) => const GuestDetailPage(),
      },
      // Show GuestListPage for the default route.
      initialRoute: '/',
    );
  }
}