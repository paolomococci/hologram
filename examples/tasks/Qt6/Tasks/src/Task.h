#pragma once

#include <QObject>
#include <QString>

/*
 * Task represents a single to‑do item.  It exposes properties that
 * QML can bind to: title, description, urgency, and completion status.
 */
class Task : public QObject {
  Q_OBJECT
  Q_PROPERTY(QString title READ title WRITE setTitle NOTIFY titleChanged)
  Q_PROPERTY(QString description READ description WRITE setDescription NOTIFY
                 descriptionChanged)
  Q_PROPERTY(bool urgent READ urgent WRITE setUrgent NOTIFY urgentChanged)
  Q_PROPERTY(
      bool completed READ completed WRITE setCompleted NOTIFY completedChanged)

public:
  explicit Task(QObject *parent = nullptr);

  // Getters
  QString title() const;
  QString description() const;
  bool urgent() const;
  bool completed() const;

  // Setters
  void setTitle(const QString &title);
  void setDescription(const QString &description);
  void setUrgent(bool urgent);
  void setCompleted(bool completed);

signals:
  void titleChanged();
  void descriptionChanged();
  void urgentChanged();
  void completedChanged();

private:
  QString m_title;
  QString m_description;
  bool m_urgent = false;
  bool m_completed = false;
};