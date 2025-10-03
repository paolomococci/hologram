#include "TaskProvider.h"

TaskProvider::TaskProvider(QObject *parent)
    : QObject(parent), m_model(new TaskModel(this)) {
  // Pre‑populate the model with a few example tasks
  m_model->addTask("Example of task number one",
                   "A brief description of the first task.", false, false);
  m_model->addTask("Example of task number two",
                   "A brief description of the second task.", false, true);
  m_model->addTask("Example of task number three",
                   "A brief description of the third task.", true, false);
  m_model->addTask("Example of task number four",
                   "A brief description of the fourth task.", true, true);
}

TaskModel *TaskProvider::model() const { return m_model; }