import QtQuick 2.15
import QtQuick.Controls 2.15
import QtQuick.Layouts 1.15

/*
 * ScaffoldWithAppBar provides a very basic “app scaffold” – a
 * top‑level toolbar and a transparent background that can be reused
 * by other pages.
 */
Item {
    id: root
    width: parent ? parent.width : 640
    height: parent ? parent.height : 480

    Column {
        anchors.fill: parent

        // ------------------------------------------------------------------
        // Toolbar at the top of the window
        // ------------------------------------------------------------------
        ToolBar {
            id: appBar
            contentHeight: 48
            RowLayout {
                anchors.fill: parent
                spacing: 8

                // App title on the left
                Label { text: "Task Manager"; font.pixelSize: 18 }

                // Spacer to push the icon to the right
                Item { Layout.fillWidth: true }

                // App icon image
                Image { source: "qrc:/images/icon.svg"; width: 32; height: 32 }
            }
        }

        // Transparent rectangle that takes up the remaining space
        Rectangle {
            anchors.left: parent.left
            anchors.right: parent.right
            anchors.top: appBar.bottom
            anchors.bottom: parent.bottom
            color: "transparent"
        }
    }
}