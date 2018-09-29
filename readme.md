<h1 align="center">Eve Commander</h1>
<p align="center">
    <a href="https://github.styleci.io/repos/117507559"><img src="https://github.styleci.io/repos/117507559/shield" alt="Style Status"></a>
    <a href="https://travis-ci.org/evecommander/evecommander-api"><img src="https://travis-ci.org/evecommander/evecommander-api.svg?branch=master" alt="Build Status"></a>
</p>

## About Eve Commander

Eve Commander is a full-service web platform for managing organizations in the popular MMO [Eve Online](https://www.eveonline.com/). It is built with segregated front and back-ends where the front-end is an Angular2 app and the back-end is a JSON:API compliant PHP server built with the Laravel framework.

Documentation coming soon!

## Local Development

This project makes heavy use of Docker and with the help of [Vessel](https://github.com/shipping-docker/vessel), a local environment is quick and easy to set up. Vessel utilizes Docker Compose to spin up spin up the following containers:
 
 - PHP FPM + Apache containing API files
 - PostgresSQL 10 Server
 - Redis Server
 - Laravel Echo Server (Event Broadcasting)
 
Refer to [Vessel](https://github.com/shipping-docker/vessel) documentation for common commands and usage.

## Production and Staging

Because of my own curiosity (perhaps stupidity?), [Kubernetes](https://github.com/kubernetes/kubernetes) will be used for both Staging and Production environments, with the former simply being a local cluster I will be implementing. These will be defined in a "kubernetes" folder in the root of the project that will contain a [Helm](https://github.com/helm/helm) Chart definition used for deployment.

It will be expected that there already be deployments of PostgreSQL 10 and Redis deployed (using these Charts; [stolon](https://github.com/helm/charts/tree/master/stable/stolon) and [redis-ha](https://github.com/helm/charts/tree/master/stable/redis-ha) respectively) to the cluster before this app is deployed.
