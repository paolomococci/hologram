import { Text } from "react-native";
import { FlatList, View, StyleSheet, TouchableOpacity } from "react-native";
import { useTaskContext } from "../context/TaskProvider";
import { TaskTile } from "../components/TaskTile";
import { ListPlus } from 'lucide-react-native';

export const TaskListPage = ({ navigation }) => {
  // Invariant Violation: View config getter callback for component `path` must be a function (received `undefined`). Make sure to start component names with a capital letter.
  const { tasks } = useTaskContext();

  const navigateNew = () => navigation.navigate("NewTask");

  const navigateEdit = (id) => navigation.navigate("EditTask", { id });

  return (
    <View style={styles.container}>
      <FlatList
        data={tasks}
        keyExtractor={(t) => t.id.toString()}
        renderItem={({ item }) => (
          <TaskTile task={item} onEdit={() => navigateEdit(item.id)} />
        )}
        ListEmptyComponent={() => (
          <View style={styles.empty}>
            <Text>No tasks yet.</Text>
          </View>
        )}
      />

      <TouchableOpacity style={styles.fab} onPress={navigateNew}>
        <Text>
          <ListPlus color="#fff" size={32} strokeWidth={2} />
        </Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1 },
  fab: {
    position: "absolute",
    right: 20,
    bottom: 20,
    backgroundColor: "#060",
    width: 56,
    height: 56,
    borderRadius: 28,
    justifyContent: "center",
    alignItems: "center",
  },
  empty: { alignItems: "center", marginTop: 32 },
});