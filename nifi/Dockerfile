FROM apache/nifi:latest

COPY nifi-stanfordcorenlp-nar-1.2.nar $NIFI_HOME/

RUN apt-get update && \
    apt-get -y upgrade && \
    apt-get install -y python3 python3-pip && \
    pip3 install -r $NIFI_HOME/requirements.in

COPY nifi-stanfordcorenlp-nar-1.2.nar $NIFI_HOME/lib/

RUN sed -i "s/#java.arg.2=-Xms512m/java.arg.2=-Xms4g/g" $NIFI_HOME/conf/bootstrap.conf && \
    sed -i "s/#java.arg.3=-Xmx512m/java.arg.3=-Xmx4g/g" $NIFI_HOME/conf/bootstrap.conf
