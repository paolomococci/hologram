import { useState, useEffect } from "react";
import {
  View,
  Text,
  TextInput,
  Switch,
  Button,
  StyleSheet,
  ScrollView,
} from "react-native";
import { useTaskContext } from "../context/TaskProvider";
import { setEditName } from "../utils/functions";

export const EditTaskPage = ({ route, navigation }) => {
  const { id } = route.params; // passed from navigation.navigate('/edit', { id })
  const { tasks, updateTask } = useTaskContext();

  const task = tasks.find((t) => t.id === id);

  const [name, setName] = useState(task?.name ?? "");
  const [description, setDescription] = useState(task?.description ?? "");
  const [isUrgent, setIsUrgent] = useState(task?.isUrgent ?? false);
  const [isDone, setIsDone] = useState(task?.isDone ?? false);

  const onSave = () => {
    if (!name.trim() || !description.trim()) {
      alert("Name & Description are required");
      return;
    }
    const updated = {
      ...task,
      name: name.trim(),
      description: description.trim(),
      isUrgent,
      isDone,
    };
    updateTask(updated);
    navigation.goBack();
  };

  if (!task) {
    return (
      <View style={styles.center}>
        <Text>Task not found.</Text>
      </View>
    );
  }

  const headerTitle = `Edit Task (${setEditName(
    tasks.findIndex((t) => t.id === id)
  )})`;

  // Use navigation options to set the header title (works only in stack)
  useEffect(() => {
    navigation.setOptions({
      title: headerTitle,
      headerStyle: { backgroundColor: "#060" },
      headerTintColor: "#fff",
    });
  }, [navigation]);

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.label}>Name</Text>
      <TextInput
        style={styles.input}
        placeholder="Task name"
        value={name}
        onChangeText={setName}
      />

      <Text style={styles.label}>Description</Text>
      <TextInput
        style={[styles.input, { height: 120 }]}
        placeholder="Task description"
        multiline
        value={description}
        onChangeText={setDescription}
      />

      <View style={styles.switchRow}>
        <Text>Is Urgent</Text>
        <Switch value={isUrgent} onValueChange={setIsUrgent} />
      </View>

      <View style={styles.switchRow}>
        <Text>Is Done</Text>
        <Switch value={isDone} onValueChange={setIsDone} />
      </View>

      <View style={styles.btnContainer}>
        <Button title="Save" color="#060" onPress={onSave} />
      </View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: { padding: 16 },
  label: { fontSize: 16, marginBottom: 4, marginTop: 12 },
  input: {
    borderWidth: 1,
    borderColor: "#ccc",
    borderRadius: 4,
    padding: 8,
  },
  switchRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    marginTop: 12,
  },
  btnContainer: { marginTop: 24 },
  center: { flex: 1, justifyContent: "center", alignItems: "center" },
});