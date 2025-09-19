import 'package:flutter/material.dart';
import '../models/task.dart';

/// Widget that displays a single task in the list
/// The UI is simple but complete
class TaskTile extends StatelessWidget {
  final ElementTaskStruct task;
  final VoidCallback onEdit;

  const TaskTile({super.key, required this.task, required this.onEdit});

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text(
        task.name,
        style: const TextStyle(fontWeight: FontWeight.bold),
      ),
      subtitle: Text(task.description),
      leading: Icon(
        task.isUrgent ? Icons.priority_high : Icons.task,
        color: task.isUrgent ? Colors.red : Colors.grey,
      ),
      trailing: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(
            task.isDone ? Icons.check_circle : Icons.radio_button_unchecked,
            color: task.isDone ? Colors.green : Colors.grey,
          ),
          const SizedBox(width: 8),
          IconButton(icon: const Icon(Icons.edit), onPressed: onEdit),
        ],
      ),
    );
  }
}
