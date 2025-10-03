#include "Task.h"

Task::Task(QObject *parent)
    : QObject(parent), m_title(), m_description(), m_urgent(false),
      m_completed(false) {}

QString Task::title() const { return m_title; }
QString Task::description() const { return m_description; }
bool Task::urgent() const { return m_urgent; }
bool Task::completed() const { return m_completed; }

void Task::setTitle(const QString &t) {
  if (m_title == t)
    return;
  m_title = t;
  emit titleChanged();
}
void Task::setDescription(const QString &d) {
  if (m_description == d)
    return;
  m_description = d;
  emit descriptionChanged();
}
void Task::setUrgent(bool u) {
  if (m_urgent == u)
    return;
  m_urgent = u;
  emit urgentChanged();
}
void Task::setCompleted(bool c) {
  if (m_completed == c)
    return;
  m_completed = c;
  emit completedChanged();
}