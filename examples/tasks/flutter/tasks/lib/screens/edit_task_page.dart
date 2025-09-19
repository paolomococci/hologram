import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/task_provider.dart';
import '../models/task.dart';
import '../utils/functions.dart';

/// Screen that allows editing an existing task.
/// The task ID is passed via the route `arguments`.
class EditTaskPage extends StatefulWidget {
  const EditTaskPage({super.key});

  @override
  State<EditTaskPage> createState() => _EditTaskPageState();
}

class _EditTaskPageState extends State<EditTaskPage> {
  final _formKey = GlobalKey<FormState>();

  late TextEditingController _nameController;
  late TextEditingController _descriptionController;

  bool _isUrgent = false;
  bool _isDone = false;

  int? _taskId;
  bool _isInitialized = false;

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    if (!_isInitialized) {
      final args = ModalRoute.of(context)!.settings.arguments;
      if (args is int) {
        _taskId = args;
        final provider = Provider.of<TaskProvider>(context, listen: false);
        final task = provider.taskAt(provider.indexOfTask(_taskId!));

        _nameController = TextEditingController(text: task.name);
        _descriptionController = TextEditingController(text: task.description);
        _isUrgent = task.isUrgent;
        _isDone = task.isDone;
        _isInitialized = true;
      }
    }
  }

  @override
  void dispose() {
    _nameController.dispose();
    _descriptionController.dispose();
    super.dispose();
  }

  /// Saves the edited task and returns to the list
  void _saveEditedTask() {
    if (_formKey.currentState!.validate() && _taskId != null) {
      final provider = Provider.of<TaskProvider>(context, listen: false);
      final updatedTask = ElementTaskStruct(
        id: _taskId!,
        name: _nameController.text.trim(),
        description: _descriptionController.text.trim(),
        isUrgent: _isUrgent,
        isDone: _isDone,
      );
      provider.updateTask(updatedTask);
      Navigator.pop(context);
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_taskId == null) {
      return Scaffold(
        appBar: AppBar(title: const Text('Edit Task')),
        body: const Center(child: CircularProgressIndicator()),
      );
    }

    final provider = Provider.of<TaskProvider>(context);
    provider.taskAt(provider.indexOfTask(_taskId!));

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.green, // background green
        foregroundColor: Colors.white, // text color
        centerTitle: true, // centered title
        title: Text(
          'Edit Task (${setEditName(provider.indexOfTask(_taskId!))})',
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              // Name
              TextFormField(
                controller: _nameController,
                decoration: const InputDecoration(labelText: 'Name'),
                validator: (value) =>
                    value == null || value.isEmpty ? 'Name is required' : null,
              ),
              const SizedBox(height: 16),
              // Description
              TextFormField(
                controller: _descriptionController,
                decoration: const InputDecoration(labelText: 'Description'),
                maxLines: 4,
                validator: (value) => value == null || value.isEmpty
                    ? 'Description is required'
                    : null,
              ),
              const SizedBox(height: 16),
              // Switch “Urgent”
              SwitchListTile(
                title: const Text('Is Urgent'),
                value: _isUrgent,
                onChanged: (v) => setState(() => _isUrgent = v),
              ),
              // Switch “Done”
              SwitchListTile(
                title: const Text('Is Done'),
                value: _isDone,
                onChanged: (v) => setState(() => _isDone = v),
              ),
              const Spacer(),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: _saveEditedTask,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.green, // background color
                    foregroundColor: Colors.white, // text color
                    padding: const EdgeInsets.symmetric(
                      horizontal: 24,
                      vertical: 12,
                    ),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(8),
                    ),
                  ),
                  child: const Text('Save'),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
