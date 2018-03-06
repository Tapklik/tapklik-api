# Courier

Is a Tapklik notification package. Producers can notify different
channels and users about certain events taking place. 

The package is very simple. It provides a convenient way of relaying simple
messages in a "set and forget" manner through simple JSON structure.

Producers have an option to send messages to one or multiple services (slack, mail, ...).
As new services are added we just need to simply extend an endpoint main consumer
with the logic of a service.

## JSON structure

```json
{
    service: [‘mail’, ‘slack’,...], // multiple available
    message: ‘’,
    timestamp: ‘’,
    groups: [],
    accounts: [],
    users: [1,2,3,...] // pass user ids,
    schedule: ‘2018-02-01 12:20:00’
}
```

* **SERVICE** array - name of consuming service. 
Naming convention **{{SERVICE_NAME}}Driver** 
i.e. **OneadDriver**, **MailDriver**, **SlackDriver**
* **MESSAGE** string - body of a message
* **TIMESTAMP** timestamp - time when the message was produced
* **GROUPS** array - integers of groups
* **ACCOUNTS** array - integers of accounts
* **USERS** array - integers of users
* **SCHEDULE** string - date time representation of when the message should be sent

## USAGE

### Sending
Simply send a POST request with the json structure above specifying at least
one service and user.

### Receiving
    Send a GET request to /v1/core/notifications/onead/{{USER_ID}}
    i.e. /v1/core/notifications/onead/a084c18814
