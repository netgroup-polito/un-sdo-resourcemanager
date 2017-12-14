# un-sdo-resourcemanager

This is a mock implementation of the ResourceManager for the Universal-Node orchestrator when used with KVM and libvirt.

# Dependencies 

```
apt-get install apache2 libapache2-mod-php php-libvirt-php
```

# Installation

- Copy all this file inside the www-root of Apache2 (e.g. /var/www or /var/www/html)

- Uncomments this two lines inside /etc/libvirt/libvirtd.conf:
```
	unix_sock_group = "libvirtd"
	unix_sock_rw_perms = "0770"
```

- Adds your unix user inside the "libvirtd" group

- Updates the files update_resources.php and password.txt with the right credentials

# HTTP API

- GET  events.php : returns the list of events happened

Example:

```
{
        "eventId": 1,
        "eventType":"NONE",
        "serviceId": 1,
        "updateNum": null
}
```

- GET  resources_available.php : returns the list of availabe resources 

Example:
```
[
	{
		"id":"CPU0",
		"type":"CPU",
		"usedBy":null,
		"isUsed":false
	},
	...
]
```

- POST update_resources.php : updates the resource used by a service

This API receives the same JSON object retrived by resources_available.php, but the SDO can modify the usedBy and isUsed property in order to mark the resource as used or released 

# CLI tool

This CLI tool updates the available number of resources of type CPU and generate an event to inform the SDO

```
./up.php new_number_of_cpu_available
```
