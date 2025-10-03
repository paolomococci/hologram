import QtQuick 2.15
import QtQuick.Controls 2.15
import QtQuick.Layouts 1.15

/*
* NewTaskPage lets the user create a new Task. The form fields
* are local and only commit the data when the “Save” button is
* pressed – at that point the new task is added to the model.
*/
Page {
    id: page
    title: "New Task"

    // Reference to the navigation stack
    property var mainStack: null

        // ------------------------------------------------------------------
        // Form layout
        // ------------------------------------------------------------------
        ColumnLayout {
            anchors.fill: parent
            anchors.margins: 12
            spacing: 8

            TextField { id: titleField; placeholderText: "Title" }
            TextArea { id: descriptionField; placeholderText: "Description"; Layout.preferredHeight: 120 }
            RowLayout {
                spacing: 8
                CheckBox { id: urgent; text: "Urgent" }
                CheckBox { id: completed; text: "Completed" }
            }
            RowLayout {
                spacing: 8
                // Save button – pushes the new task onto the model
                Button {
                    text: "Save"
                    // Grab the current values from the UI
                    onClicked: {
                        if (titleField.text.trim().length === 0)
                        {
                            console.warn("Title empty");
                            return;
                        }
                        // Add the task to the model via the provider
                        taskProvider.model.addTask(titleField.text, descriptionField.text, urgent.checked, completed.checked);

                        // Return to the previous page
                        if (mainStack)
                        {
                            mainStack.pop();
                        } else {
                        console.error("mainStack is null in NewTaskPage");
                    }
                }
            }
            // Cancel button – simply goes back
            Button {
                text: "Cancel"
                onClicked: {
                    if (mainStack)
                    {
                        mainStack.pop();
                    } else {
                    console.error("mainStack is null in NewTaskPage");
                }
            }
        }
    }
}
}
