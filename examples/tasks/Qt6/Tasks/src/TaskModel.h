#pragma once
#include "Task.h"
#include <QAbstractListModel>
#include <QVector>

/*
 * TaskModel is a QAbstractListModel that stores a QVector of Task*
 * pointers.  It provides QML with the ability to query, add, remove,
 * and update tasks.
 */
class TaskModel : public QAbstractListModel {
  Q_OBJECT
public:
  enum Roles {
    TitleRole = Qt::UserRole + 1,
    DescriptionRole,
    UrgentRole,
    CompletedRole
  };
  explicit TaskModel(QObject *parent = nullptr);

  // Required overrides
  int rowCount(const QModelIndex &parent = QModelIndex()) const override;
  QVariant data(const QModelIndex &index,
                int role = Qt::DisplayRole) const override;
  QHash<int, QByteArray> roleNames() const override;

  // Public methods callable from QML
  Q_INVOKABLE void addTask(const QString &title, const QString &description,
                           bool urgent = false, bool completed = false);
  Q_INVOKABLE void removeTask(int index);
  Q_INVOKABLE void updateTask(int index, const QString &title,
                              const QString &description, bool urgent,
                              bool completed);

  Q_INVOKABLE QObject *taskAt(int index) const;

private:
  QVector<Task *> m_tasks; // Internal storage
};