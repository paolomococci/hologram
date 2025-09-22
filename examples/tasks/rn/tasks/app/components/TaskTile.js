import { StyleSheet, Text, View, TouchableOpacity, Switch } from "react-native";
import { Shield, ShieldAlert, Circle, CircleCheckBig, PencilLine } from 'lucide-react-native';

export const TaskTile = ({ task, onEdit }) => (
    <View style={styles.container}>
        <View style={styles.left}>
            {task.isUrgent ? (
                <ShieldAlert
                    size={24}
                    color="#a00"
                    strokeWidth={3}
                />
            ) : (
                <Shield
                    size={24}
                    color="#0a0"
                />
            )}
            <View style={styles.info}>
                <Text style={styles.name} numberOfLines={1} ellipsizeMode="tail">{task.name}</Text>
                <Text style={styles.description} numberOfLines={1} ellipsizeMode="tail">{task.description}</Text>
            </View>
        </View>

        <View style={styles.right}>
            {task.isDone ? (
                <CircleCheckBig
                    size={24}
                    color="#0a0"
                    strokeWidth={3}
                />
            ) : (
                <Circle
                    size={24}
                    color="#a00"
                />
            )}
            <TouchableOpacity onPress={onEdit} style={styles.editBtn}>
                <PencilLine color="#0a0" size={20} />
            </TouchableOpacity>
        </View>
    </View>
);

const styles = StyleSheet.create({
    container: {
        padding: 12,
        borderBottomWidth: 1,
        borderBottomColor: "#eee",
        flexDirection: "row",
        alignItems: "center",
        justifyContent: "space-between",
    },
    left: { flexDirection: "row", alignItems: "center" },
    info: { marginLeft: 12 },
    name: { fontWeight: "bold", fontSize: 16, width: 150, },
    description: { color: "#666", fontSize: 14, width: 200, },
    right: { flexDirection: "row", alignItems: "center" },
    editBtn: { marginLeft: 12 },
});