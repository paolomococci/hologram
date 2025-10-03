#pragma once

#include <QObject>

/*
 * An empty QObject-derived class.  It is registered for QML so that
 * its (currently empty) methods can be called from QML if needed.
 */
class Functions : public QObject {
  Q_OBJECT
public:
  explicit Functions(QObject *parent = nullptr) : QObject(parent) {}
};