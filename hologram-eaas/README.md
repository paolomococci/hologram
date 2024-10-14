# hologram-eaas (Environment as a Service)

Looking ahead, I am preparing a set of procedures to build the backbone of a local multi-node Eaas, (Environment as a Service), example.
A type of Eaas in `on premise` configuration thanks to a virtual server with GNU/Linux AlmaLinux 9.4 installed.

When using this distribution you need to consider the `SELinux` system.
For example, directories used by containers must have a property set correctly:

```bash
ls -lZ
chcon --recursive --type=container_file_t html
```

It is good to remember that the link addresses mentioned in the procedures may change.
The procedures themselves may change or there may be more convenient ones.
Therefore, it is always necessary to refer to the official documentation hosted on the sites of the programming languages, servers and tools mentioned from time to time.
Thank you.
