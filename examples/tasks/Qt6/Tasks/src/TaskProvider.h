#pragma once
#include "TaskModel.h"
#include <QObject>

/*
 * TaskProvider owns a TaskModel instance and exposes it as a property
 * to be used by QML.  It acts as a simple data service for the UI.
 */
class TaskProvider : public QObject {
  Q_OBJECT
  Q_PROPERTY(TaskModel *model READ model CONSTANT)
public:
  explicit TaskProvider(QObject *parent = nullptr);
  TaskModel *model() const;

private:
  TaskModel *m_model;
};