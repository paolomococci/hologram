#include "TaskModel.h"
#include <QDebug>

TaskModel::TaskModel(QObject *parent) : QAbstractListModel(parent) {}

int TaskModel::rowCount(const QModelIndex &parent) const {
  if (parent.isValid())
    return 0;
  return m_tasks.size();
}

QVariant TaskModel::data(const QModelIndex &index, int role) const {
  if (!index.isValid() || index.row() < 0 || index.row() >= m_tasks.size())
    return {};
  Task *t = m_tasks.at(index.row());
  switch (role) {
  case TitleRole:
    return t->title();
  case DescriptionRole:
    return t->description();
  case UrgentRole:
    return t->urgent();
  case CompletedRole:
    return t->completed();
  default:
    return {};
  }
}

QHash<int, QByteArray> TaskModel::roleNames() const {
  QHash<int, QByteArray> roles;
  roles[TitleRole] = "title";
  roles[DescriptionRole] = "description";
  roles[UrgentRole] = "urgent";
  roles[CompletedRole] = "completed";
  return roles;
}

void TaskModel::addTask(const QString &title, const QString &description,
                        bool urgent, bool completed) {
  beginInsertRows(QModelIndex(), m_tasks.size(), m_tasks.size());
  Task *t = new Task(this);
  t->setTitle(title);
  t->setDescription(description);
  t->setUrgent(urgent);
  t->setCompleted(completed);
  m_tasks.append(t);
  endInsertRows();
}

void TaskModel::removeTask(int index) {
  if (index < 0 || index >= m_tasks.size())
    return;
  beginRemoveRows(QModelIndex(), index, index);
  Task *t = m_tasks.takeAt(index);
  delete t;
  endRemoveRows();
}

void TaskModel::updateTask(int index, const QString &title,
                           const QString &description, bool urgent,
                           bool completed) {
  if (index < 0 || index >= m_tasks.size())
    return;
  Task *t = m_tasks.at(index);
  t->setTitle(title);
  t->setDescription(description);
  t->setUrgent(urgent);
  t->setCompleted(completed);
  QModelIndex idx = createIndex(index, 0);
  emit dataChanged(idx, idx,
                   {TitleRole, DescriptionRole, UrgentRole, CompletedRole});
}

QObject *TaskModel::taskAt(int index) const {
  if (index < 0 || index >= m_tasks.size())
    return nullptr;
  return m_tasks.at(index);
}