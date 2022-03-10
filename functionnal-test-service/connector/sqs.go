package connector

import (
	"errors"
	"github.com/aws/aws-sdk-go/aws"
	"github.com/aws/aws-sdk-go/aws/session"
	"github.com/aws/aws-sdk-go/service/sqs"
	"os"
)

func GetSession() *session.Session {
	sess := session.Must(session.NewSessionWithOptions(session.Options{
		SharedConfigState: session.SharedConfigEnable,
		Config: aws.Config{
			Region: aws.String("eu-west-3"),
		},
	}))
	return sess
}

func ReceiveMessage() (*sqs.ReceiveMessageOutput, error) {
	sess := GetSession()
	svc := sqs.New(sess)
	qURL := os.Getenv("SQS_QUEUE")
	result, err := svc.ReceiveMessage(&sqs.ReceiveMessageInput{
		AttributeNames: []*string{
			aws.String(sqs.MessageSystemAttributeNameSentTimestamp),
		},
		MessageAttributeNames: []*string{
			aws.String(sqs.QueueAttributeNameAll),
		},
		QueueUrl:            &qURL,
		MaxNumberOfMessages: aws.Int64(10),
		VisibilityTimeout:   aws.Int64(60), // 60 seconds
		WaitTimeSeconds:     aws.Int64(20),
	})
	if err != nil {
		return nil, err
	}
	if len(result.Messages) == 0 {
		return nil, errors.New("Received no messages")
	}
	return result, nil
}

