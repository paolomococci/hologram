import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:tasks/providers/task_provider.dart';
import 'package:tasks/screens/edit_task_page.dart';
import 'package:tasks/screens/new_task_page.dart';
import 'package:tasks/screens/task_list_page.dart';
import 'package:tasks/widgets/scaffold_with_app_bar.dart';

void main() {
  runApp(
    ChangeNotifierProvider(create: (_) => TaskProvider(), child: const MyApp()),
  );
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of this app.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Tasks Management',
      theme: ThemeData(primarySwatch: Colors.blue),
      initialRoute: '/',
      routes: {
        '/': (_) =>
            ScaffoldWithAppBar(title: 'Task List', child: const TaskListPage()),
        '/new': (_) =>
            ScaffoldWithAppBar(title: 'New Task', child: const NewTaskPage()),
        '/edit': (_) => const EditTaskPage(),
      },
    );
  }
}
