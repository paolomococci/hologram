import 'package:flutter/foundation.dart';
import '../models/task.dart';

/// ChangeNotifier that maintains a list of tasks and offers CRUD methods.
/// Every change calls `notifyListeners()`.
class TaskProvider extends ChangeNotifier {
  final List<ElementTaskStruct> _tasks = [];

  /// Returns an immutable copy of the list
  List<ElementTaskStruct> get tasks => List.unmodifiable(_tasks);

  /// Adds a task
  void addTask(ElementTaskStruct task) {
    _tasks.add(task);
    notifyListeners();
  }

  /// Updates the task with the same `id`
  void updateTask(ElementTaskStruct updated) {
    final idx = _tasks.indexWhere((t) => t.id == updated.id);
    if (idx != -1) {
      _tasks[idx] = updated;
      notifyListeners();
    }
  }

  /// Removes a task (not used in the demo but useful for extension)
  void removeTask(int id) {
    _tasks.removeWhere((t) => t.id == id);
    notifyListeners();
  }

  /// Returns the task at the given index
  ElementTaskStruct taskAt(int index) => _tasks[index];

  /// Finds the index of the task with the given `id`
  int indexOfTask(int id) => _tasks.indexWhere((t) => t.id == id);

  /// First available ID (useful for generating a new `id`)
  int get firstAvailableId {
    if (_tasks.isEmpty) return 1;
    final ids = _tasks.map((t) => t.id).toSet();
    int i = 1;
    while (ids.contains(i)) {
      i++;
    }
    return i;
  }
}
