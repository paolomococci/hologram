import QtQuick 2.15
import QtQuick.Controls 2.15
import QtQuick.Layouts 1.15

/*
* EditTaskPage allows the user to edit the details of an existing task.
* The page is pushed onto the StackView when the user clicks the
* “Edit” button from a TaskTile.
*/
Page {
    id: page
    property int taskIndex: -1
        property var mainStack: null
            title: "Edit Task"

            // ------------------------------------------------------------------
            // UI layout – a simple scaffold for the edit form
            // ------------------------------------------------------------------
            ColumnLayout {
                anchors.fill: parent
                anchors.margins: 12  // Use margins instead of padding
                spacing: 8

                TextField {
                    id: titleField
                    placeholderText: "Title"
                    Layout.fillWidth: true
                }

                TextArea {
                    id: descriptionField
                    placeholderText: "Description"
                    Layout.preferredHeight: 120
                    Layout.fillWidth: true
                }

                RowLayout {
                    spacing: 8
                    CheckBox { id: urgent; text: "Urgent" }
                    CheckBox { id: completed; text: "Completed" }
                }

                // Save button
                RowLayout {
                    spacing: 8
                    Button {
                        text: "Save"
                        onClicked: {
                            if (taskIndex < 0) return;
                            taskProvider.model.updateTask(taskIndex, titleField.text, descriptionField.text, urgent.checked, completed.checked);

                            if (mainStack)
                            {
                                mainStack.pop();
                            } else {
                            console.error("mainStack is null in EditTaskPage");
                        }
                    }
                }
                // Cancel button – simply goes back without changes
                Button {
                    text: "Cancel"
                    onClicked: {
                        if (mainStack)
                        {
                            mainStack.pop();
                        } else {
                        console.error("mainStack is null in EditTaskPage");
                    }
                }
            }
        }
    }

    // ------------------------------------------------------------------
    // Bind to the Task object based on the provided index
    // ------------------------------------------------------------------
    Component.onCompleted: {
        if (taskIndex >= 0)
        {
            var t = taskProvider.model.taskAt(taskIndex);
            if (t)
            {
                titleField.text = t.title;
                descriptionField.text = t.description;
                urgent.checked = t.urgent;
                completed.checked = t.completed;
            }
        }
    }
}
