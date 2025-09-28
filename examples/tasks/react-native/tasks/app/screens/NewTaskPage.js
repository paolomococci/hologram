import { useState } from "react";
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

export const NewTaskPage = ({ navigation }) => {
  const { addTask, firstAvailableId } = useTaskContext();

  const [name, setName] = useState("");
  const [description, setDescription] = useState("");
  const [isUrgent, setIsUrgent] = useState(false);
  const [isDone, setIsDone] = useState(false);

  const onSave = () => {
    if (!name.trim() || !description.trim()) {
      alert("Name & Description are required");
      return;
    }
    const newTask = {
      id: firstAvailableId(),
      name: name.trim(),
      description: description.trim(),
      isUrgent,
      isDone,
    };
    addTask(newTask);
    navigation.goBack();
  };

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
});