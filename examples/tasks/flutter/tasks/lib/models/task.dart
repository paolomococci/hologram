/// Structure that represents a task
/// All fields are marked as `required` to guarantee data integrity
class ElementTaskStruct {
  final int id; // Unique identifier
  final String name; // Task name
  final String description; // Description
  final bool isUrgent; // If it is urgent
  final bool isDone; // If it is completed

  const ElementTaskStruct({
    required this.id,
    required this.name,
    required this.description,
    required this.isUrgent,
    required this.isDone,
  });

  /// Creates a modified copy of the task
  ElementTaskStruct copyWith({
    int? id,
    String? name,
    String? description,
    bool? isUrgent,
    bool? isDone,
  }) {
    return ElementTaskStruct(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      isUrgent: isUrgent ?? this.isUrgent,
      isDone: isDone ?? this.isDone,
    );
  }

  /// Serialization for persistence or backend transmission
  Map<String, dynamic> toJson() => {
    'id': id,
    'name': name,
    'description': description,
    'isUrgent': isUrgent,
    'isDone': isDone,
  };

  /// Deserialization
  factory ElementTaskStruct.fromJson(Map<String, dynamic> json) =>
      ElementTaskStruct(
        id: json['id'] as int,
        name: json['name'] as String,
        description: json['description'] as String,
        isUrgent: json['isUrgent'] as bool,
        isDone: json['isDone'] as bool,
      );
}
