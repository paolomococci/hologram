import { View, Text, StyleSheet, SafeAreaProvider } from "react-native";

export const ScaffoldWithAppBar = ({ title, children }) => (
  <SafeAreaProvider style={styles.container}>
    <View style={styles.appBar}>
      <Text style={styles.title}>{title}</Text>
    </View>
    <View style={styles.content}>{children}</View>
  </SafeAreaProvider>
);

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: "#fff" },
  appBar: {
    height: 56,
    backgroundColor: "#060",
    justifyContent: "center",
    alignItems: "center",
  },
  title: { color: "#fff", fontSize: 18, fontWeight: "bold" },
  content: { flex: 1, padding: 16 },
});