# tasks

A simple application to become familiar with layouts.

## tree of `tasks` project

```text
.
├── lib
│   ├── main.dart
│   ├── models
│   │   └── task.dart
│   ├── providers
│   │   └── task_provider.dart
│   ├── screens
│   │   ├── edit_task_page.dart
│   │   ├── new_task_page.dart
│   │   └── task_list_page.dart
│   ├── utils
│   │   └── functions.dart
│   └── widgets
│       ├── scaffold_with_app_bar.dart
│       └── task_tile.dart
└── pubspec.yaml
```

## scaffolding

Create app:

```shell
flutter create --suppress-analytics \
--template=app \
--platforms linux,web,android \
--empty \
--description "A simple application to become familiar with layouts." \
--org "local.hologram" \
--android-language kotlin \
tasks
```

Go to directory project:

```shell
cd tasks/
```

Install dependencies:

```shell
flutter pub add provider
```

Try this app on linux:

```shell
flutter run --device-id linux
```

Try app on chrome:

```shell
flutter run --device-id chrome
```

Try app on android:

```shell
flutter emulators
```

and now type:

```shell
flutter emulators --launch id_of_emulator && flutter devices && flutter run --device-id emulator-5554
```

## WASM

Check configurations:

```shell
flutter doctor -v
flutter config --enable-web
```

To run type:

```shell
flutter run --wasm --device-id chrome
```

To build app type:

```shell
flutter build web --wasm
```

Build for debug:

```shell
flutter build web --wasm --debug
```

Build for production environment:

```shell
flutter build web --wasm --release
```

## Screenshots

### desktop device

![task list on linux device](./screenshots/desktop/tasks_linux_device_task_list_page.png "Task list on Linux device")

![task new on linux device](./screenshots/desktop/tasks_linux_device_new_task_page.png "New task on Linux device")

![task edit on linux device](./screenshots/desktop/tasks_linux_device_edit_task_page.png "Edit task on Linux device")

### browser device

![task list on browser device](./screenshots/browser/tasks_browser_device_task_list_page.png "Task list on browser device")

![task new on browser device](./screenshots/browser/tasks_browser_device_new_task_page.png "New task on browser device")

![task edit on browser device](./screenshots/browser/tasks_browser_device_edit_task_page.png "Edit task on browser device")

### mobile device

![task list on mobile device](./screenshots/mobile/tasks_mobile_device_task_list_page.png "Task list on mobile device")

![task new on mobile device](./screenshots/mobile/tasks_mobile_device_edit_task_page.png "New task on mobile device")

![task edit on mobile device](./screenshots/mobile/tasks_mobile_device_new_task_page.png "Edit task on mobile device")
