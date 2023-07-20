# Changelog

All notable changes to this project will be documented in this file.

[Next release]
--------------


2023-07-20, 0.5.3
------------------

- Update elfinder to 2.1.62 because CVE-2023-35840

|                     studio-42/elfinder                                                               |
| CVE               | CVE-2023-35840                                                                   |
| Title             | elFinder vulnerable to path traversal in LocalVolumeDriver connector             |
| URL               | https://github.com/advisories/GHSA-wm5g-p99q-66g4                                |
| Affected versions | <2.1.62                                                                          |
| Reported at       | 2023-06-14T16:37:01+00:00


2023-02-05, 0.5.2
------------------

Allow Laravel 10
Laravel 10.x Compatibility (#321)

* Bump dependencies for Laravel 10

* Relax constraints
 

2022-03-15, 0.5.0
------------------

### Changed
 - Drop support for Laravel 8.x and older (because of Flysystem v3)
 - Fix accessControl for disks
 - Change default dir to 'storage' instead of 'files'
