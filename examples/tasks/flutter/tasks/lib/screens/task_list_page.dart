import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/task_provider.dart';
import '../widgets/task_tile.dart';

/// Screen that displays the task list.
/// The `TaskTile` widget is used for each list item.
class TaskListPage extends StatelessWidget {
  const TaskListPage({super.key});

  /// Navigate to new task
  void _goToNewTask(BuildContext context) {
    Navigator.pushNamed(context, '/new');
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Consumer<TaskProvider>(
        builder: (_, provider, __) => ListView.builder(
          itemCount: provider.tasks.length,
          itemBuilder: (_, i) => TaskTile(
            task: provider.tasks[i],
            onEdit: () => Navigator.pushNamed(
              context,
              '/edit',
              arguments: provider.tasks[i].id,
            ),
          ),
        ),
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () => _goToNewTask(context),
        backgroundColor: Colors.green, // background color
        foregroundColor: Colors.white, // icon color
        child: const Icon(Icons.add),
      ),
    );
  }
}
