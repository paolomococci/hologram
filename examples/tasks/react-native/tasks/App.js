import "react-native-gesture-handler"; // required at top of file
import { NavigationContainer } from "@react-navigation/native";
import { createNativeStackNavigator } from "@react-navigation/native-stack";
import { TaskProvider } from "./app/context/TaskProvider";
import { TaskListPage } from "./app/screens/TaskListPage";
import { NewTaskPage } from "./app/screens/NewTaskPage";
import { EditTaskPage } from "./app/screens/EditTaskPage";

const Stack = createNativeStackNavigator();

const App = () => (
  <TaskProvider>
    <NavigationContainer>
      <Stack.Navigator
        screenOptions={{
          headerStyle: { backgroundColor: "#060" },
          headerTintColor: "#fff",
          headerTitleStyle: { fontWeight: "bold" },
        }}
      >
        <Stack.Screen
          name="TaskList"
          component={TaskListPage}
          options={{ title: "Tasks" }}
        />

        <Stack.Screen
          name="NewTask"
          component={NewTaskPage}
          options={{
            title: "New Task",
            headerStyle: { backgroundColor: "#060" },
            headerTintColor: "#fff",
          }}
        />

        <Stack.Screen
          name="EditTask"
          component={EditTaskPage}
          options={{ title: "Edit Task" }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  </TaskProvider>
);

export default App;