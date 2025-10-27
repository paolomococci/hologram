# guests

## scaffolding

Create app:

```shell
flutter create --suppress-analytics \
--template=app \
--platforms linux,web,android \
--empty \
--description "guests frontend" \
--org "local.hologram" \
--android-language kotlin \
guests
```

Go to directory project:

```shell
cd guests/
```

Install dependencies:

```shell
flutter pub add http
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
