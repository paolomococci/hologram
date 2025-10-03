import QtQuick 2.15
import QtQuick.Controls 2.15
import QtQuick.Layouts 1.15

/*
 * TaskTile is a reusable component that displays a single Task’s
 * title, description, and action buttons (Edit / Delete).  It
 * exposes signals so that the parent ListView can react to user
 * interactions.
 */
Item {
    id: root
    width: parent ? parent.width : 640
    height: 80

    // Reference to the underlying Task QObject
    property QObject taskObj

    RowLayout {
        anchors.fill: parent
        spacing: 10
        Layout.margins: 8

        // Column containing the title and description
        ColumnLayout {
            Layout.fillWidth: true
            Text { text: taskObj ? taskObj.title : ""; font.pixelSize: 18 }
            Text { text: taskObj ? taskObj.description : ""; font.pixelSize: 14; color: "gray" }
        }

        // Edit button
        Button {
            text: "Edit"
            onClicked: editClicked()
        }

        // Delete button
        Button {
            text: "Delete"
            onClicked: deleteClicked()
        }
    }

    // Signals emitted when the user clicks Edit or Delete
    signal editClicked()
    signal deleteClicked()
}