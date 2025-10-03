import QtQuick 2.15
import QtQuick.Controls 2.15
import QtQuick.Layouts 1.15
import Tasks 1.0

ApplicationWindow {
    id: appWindow
    visible: true
    width: 640
    height: 480
    title: "Tasks - sample task manager"

    // ------------------------------------------------------------------
    // A StackView manages page navigation (push/pop)
    // ------------------------------------------------------------------
    StackView {
        id: mainStack
        anchors.fill: parent
        // The first page shown
        initialItem: taskListPage

        // The TaskListPage is defined in a separate QML file
        TaskListPage {
            id: taskListPage
            // Provide the stack to the page
            mainStack: mainStack
            // Hidden by default; StackView handles visibility
            visible: false
        }
    }
}