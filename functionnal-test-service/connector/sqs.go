package connector

import (
	"fmt"
	"github.com/aws/aws-sdk-go/aws/session"
	"github.com/aws/aws-sdk-go/service/sqs"
)


const (
	Region      = "eu-west-3"
	//CredPath    = "/Users/home/.aws/credentials"
	//CredProfile = "aws-cred-profile"
)

func ConnectQueue() {
	sess := session.Must(session.NewSessionWithOptions(session.Options{
		SharedConfigState: session.SharedConfigEnable,
	}))
	svc := sqs.New(sess)

	result, err := svc.ListQueues(nil)
	for i, url := range result.QueueUrls {
		fmt.Printf("%d: %s\n", i, *url)
	}
	if err != nil {
		panic(err)
	}
}

