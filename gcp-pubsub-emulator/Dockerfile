FROM google/cloud-sdk:alpine

# Install Java 8 for Pub/Sub emulator
RUN apk --update add openjdk8-jre

# Install emulator
RUN gcloud components install pubsub-emulator \
    beta

# Volume to persist Pub/Sub data
VOLUME /opt/data

# Expose the default emulator port
EXPOSE  8085

CMD ["/google-cloud-sdk/bin/gcloud","beta", "emulators", "pubsub", "start", "--host-port=0.0.0.0:8085", "--project=reverse-openapi"]