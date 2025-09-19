import 'package:flutter/material.dart';

class ScaffoldWithAppBar extends StatelessWidget {
  final String title;
  final Widget child;

  const ScaffoldWithAppBar({
    super.key,
    required this.title,
    required this.child,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.green, // background green
        foregroundColor: Colors.white, // text color
        centerTitle: true, // centered title
        title: Text(title),
      ),
      body: child,
    );
  }
}
