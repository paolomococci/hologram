#include "Functions.h"
#include "Task.h"
#include "TaskModel.h"
#include "TaskProvider.h"

#include <QDebug>
#include <QGuiApplication>
#include <QQmlApplicationEngine>
#include <QQmlContext>
#include <QtQml>

int main(int argc, char *argv[]) {
  // ------------------------------------------------------------------
  // 1. Application setup
  // ------------------------------------------------------------------
  QGuiApplication app(argc, argv);        // Create the Qt GUI application
  app.setApplicationName("Task Manager"); // Set the display name
  app.setApplicationVersion("1.0.0");     // Set the version string

  // ------------------------------------------------------------------
  // 2. Register C++ types for use in QML
  // ------------------------------------------------------------------
  qmlRegisterType<Task>("Tasks", 1, 0, "Task");
  qmlRegisterType<TaskModel>("Tasks", 1, 0, "TaskModel");
  qmlRegisterType<TaskProvider>("Tasks", 1, 0, "TaskProvider");
  qmlRegisterType<Functions>("Tasks", 1, 0, "Functions");
  // The following line registers a QML component that will be used as a
  // page later in the UI hierarchy.
  qmlRegisterType(QUrl("qrc:/src/pages/TaskListPage.qml"), "Tasks", 1, 0,
                  "TaskListPage");

  // ------------------------------------------------------------------
  // 3. Create the provider that holds the model
  // ------------------------------------------------------------------
  QScopedPointer<TaskProvider> provider(new TaskProvider(&app));

  // ------------------------------------------------------------------
  // 4. Set up the QML engine
  // ------------------------------------------------------------------
  QQmlApplicationEngine engine;

  // 4.1 Connect to QML warning signals for debugging
  QObject::connect(&engine, &QQmlApplicationEngine::warnings,
                   [](const QList<QQmlError> &warnings) {
                     for (const QQmlError &warning : warnings) {
                       qDebug() << "QML Warning:"
                                << "URL:" << warning.url()
                                << "Line:" << warning.line()
                                << "Column:" << warning.column()
                                << "Description:" << warning.toString();
                     }
                   });

  // 4.2 Expose the provider to QML via the context
  engine.rootContext()->setContextProperty("taskProvider", provider.get());

  // 4.3 The URL of the main QML file
  const QUrl url(QStringLiteral("qrc:/src/main.qml"));

  // 4.4 Connect a signal to detect if the root QML object failed to load
  QObject::connect(
      &engine, &QQmlApplicationEngine::objectCreated, &app,
      [url](QObject *obj, const QUrl &objUrl) {
        if (!obj && url == objUrl) {
          qDebug() << "Failed to create main QML object";
          QCoreApplication::exit(-1);
        }
      },
      Qt::QueuedConnection);

  // 4.5 Load the main QML file
  engine.load(url);

  // ------------------------------------------------------------------
  // 5. Debugging output
  // ------------------------------------------------------------------
  qDebug() << "Application Name:" << app.applicationName()
           << "Version:" << app.applicationVersion()
           << "Root Objects:" << engine.rootObjects().size();

  if (engine.rootObjects().isEmpty()) {
    qDebug() << "Failed to load QML";
    return -1;
  }

  // ------------------------------------------------------------------
  // 6. Start the event loop
  // ------------------------------------------------------------------
  return app.exec();
}