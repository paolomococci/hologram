import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/task_provider.dart';
import '../models/task.dart';

/// Screen with a Form to insert a new task.
/// The `SwitchListTile` widget is used for a cleaner UI.
class NewTaskPage extends StatefulWidget {
  const NewTaskPage({super.key});

  @override
  State<NewTaskPage> createState() => _NewTaskPageState();
}

class _NewTaskPageState extends State<NewTaskPage> {
  final _formKey = GlobalKey<FormState>();

  // Controllers for text fields
  final _nameController = TextEditingController();
  final _descriptionController = TextEditingController();

  // Variables for toggles
  bool _isUrgent = false;
  bool _isDone = false;

  /// Saves the new task if the fields are valid
  void _saveTask() {
    if (_formKey.currentState!.validate()) {
      final provider = Provider.of<TaskProvider>(context, listen: false);
      final newTask = ElementTaskStruct(
        id: provider.firstAvailableId,
        name: _nameController.text.trim(),
        description: _descriptionController.text.trim(),
        isUrgent: _isUrgent,
        isDone: _isDone,
      );
      provider.addTask(newTask);
      Navigator.pop(context); // return to the list
    }
  }

  @override
  void dispose() {
    _nameController.dispose();
    _descriptionController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      //appBar: AppBar(title: const Text('New Task')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              // Name field
              TextFormField(
                controller: _nameController,
                decoration: const InputDecoration(labelText: 'Name'),
                validator: (value) =>
                    value == null || value.isEmpty ? 'Name is required' : null,
              ),
              const SizedBox(height: 16),
              // Description field
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
                onChanged: (val) => setState(() => _isUrgent = val),
              ),
              // Switch “Done”
              SwitchListTile(
                title: const Text('Is Done'),
                value: _isDone,
                onChanged: (val) => setState(() => _isDone = val),
              ),
              const Spacer(),
              // Save button
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: _saveTask,
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
