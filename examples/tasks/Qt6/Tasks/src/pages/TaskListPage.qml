import QtQuick 2.15
import QtQuick.Controls 2.15
import QtQuick.Layouts 1.15
import Tasks 1.0

/*
* TaskListPage shows all existing tasks in a ListView. It includes:
* • A floating “+” button that pushes NewTaskPage.
* • A dialog to confirm deletion.
* • A delegate that uses TaskTile for each row.
*/
Page {
    id: page
    title: "Tasks"
    property StackView mainStack: null

        Component.onCompleted: {
            console.log("TaskListPage loaded successfully")
        }

        ColumnLayout {
            anchors.fill: parent
            anchors.margins: 12
            spacing: 8


            // ------------------------------------------------------------------
            // ListView that displays all tasks using a TaskTile delegate
            // ------------------------------------------------------------------
            ListView {
                id: taskList
                Layout.fillWidth: true
                Layout.fillHeight: true
                model: taskProvider.model

                delegate: Loader {
                    width: parent ? parent.width : 0
                    sourceComponent: model ? delegateComponent : null

                    Component {
                        id: delegateComponent
                        MouseArea {
                            width: parent ? parent.width : 0
                            height: 50

                            // Prevents clicking the delete button from activating task editing
                            preventStealing: true

                            Rectangle {
                                anchors.fill: parent
                                color: index % 2 === 0 ? '#aee' : '#9dc'
                                opacity: model.completed ? 0.5 : 1.0

                                RowLayout {
                                    anchors.fill: parent
                                    anchors.margins: 10
                                    spacing: 10

                                    Text {
                                        text: model.title
                                        font.pixelSize: 16
                                        Layout.fillWidth: true
                                        font.strikeout: model.completed
                                    }

                                    Text {
                                        text: model.urgent ? "rush" : "lazy"
                                        font.pixelSize: 16
                                        color: model.urgent ? '#f00' : "#333"
                                    }

                                    Text {
                                        text: model.completed ? "done" : "todo"
                                        font.pixelSize: 16
                                        color: model.completed ? '#0f0' : "#333"
                                    }

                                    // Delete button
                                    Button {
                                        text: "delete"
                                        width: 40
                                        height: 40

                                        // Use a MouseArea to handle the click event
                                        MouseArea {
                                            anchors.fill: parent
                                            onClicked: function(mouseEvent) {
                                            // Ferma la propagazione dell'evento del task
                                            mouseEvent.accepted = true

                                            // Chiedi conferma prima di eliminare
                                            confirmDeleteDialog.taskIndex = index
                                            confirmDeleteDialog.open()
                                        }
                                    }
                                }
                            }
                        }

                        onClicked: {
                            console.log("Task clicked: ", model.title, " at index ", index)

                            var editPage = Qt.resolvedUrl("qrc:/src/pages/EditTaskPage.qml")
                            mainStack.push(editPage, {
                            taskIndex: index,
                            mainStack: mainStack
                        });
                    }
                }
            }
        }

        Label {
            anchors.centerIn: parent
            visible: taskList.count === 0
            text: "No tasks. Click 'Add' to create one."
            font.pixelSize: 16
        }
    }

    Pane {
        Layout.fillWidth: true
        Layout.fillHeight: true
        padding: 0

        ColumnLayout {
            anchors.fill: parent
            spacing: 8

            ListView {
                // ... (codice precedente invariato)
            }

            Item {
                Layout.fillWidth: true
                Layout.preferredHeight: fab.height + 16
            }
        }

        // ------------------------------------------------------------------
        // Floating Action Button (FAB) – material design like
        // ------------------------------------------------------------------
        Button {
            id: fab
            text: "+"
            font.pixelSize: 24
            font.bold: true

            // Stile del FAB
            width: 56
            height: 56

            // Bottom right positioning
            anchors.right: parent.right
            anchors.bottom: parent.bottom
            anchors.margins: 16

            // FAB Style
            background: Rectangle {
                color: "#29f"  // color material design blu
                radius: 28  // Half the height to make it circular

                // Shadow simulation with opacity and border
                border.color: Qt.rgba(0, 0, 0, 0.1)
                border.width: 1
            }

            contentItem: Text {
                text: parent.text
                font: parent.font
                color: "#fff"
                horizontalAlignment: Text.AlignHCenter
                verticalAlignment: Text.AlignVCenter
            }

            onClicked: {
                console.log("Add Task button clicked")
                var newTaskPage = Qt.resolvedUrl("qrc:/src/pages/NewTaskPage.qml")
                mainStack.push(newTaskPage, {
                mainStack: mainStack
            });
        }
    }
}
}

// ------------------------------------------------------------------
// Confirmation dialog shown when the user attempts to delete
// ------------------------------------------------------------------
Dialog {
    id: confirmDeleteDialog
    property int taskIndex: -1
        title: "Confirm Deletion"
        standardButtons: Dialog.Yes | Dialog.No

        Label {
            text: "Are you sure you want to delete this task?"
        }

        onAccepted: {
            if (taskIndex >= 0)
            {
                taskProvider.model.removeTask(taskIndex);
            }
        }
    }
}
