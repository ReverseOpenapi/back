package aws

import (
	"fmt"
	"github.com/aws/aws-sdk-go/aws"
	"github.com/aws/aws-sdk-go/service/s3/s3manager"
	"github.com/back/functionnal-test-service/connector"
	"os"
)

func UploadFileOnS3(openApiId string) error {
	sess := connector.GetSession()
	uploader := s3manager.NewUploader(sess)
	f, err := os.Open("./.export/" + openApiId + ".zip")
	if err != nil {
		return err
	}
	fileExport := "./functional-test/" + openApiId + ".zip"
	res, err := uploader.Upload(&s3manager.UploadInput{
		Bucket:  aws.String(os.Getenv("S3_BUCKET")),
		Key: aws.String(fileExport),
		Body: f,
	})

	if err != nil {
		return fmt.Errorf("failed to upload file, %v", err)
	}
	fmt.Printf("file uploaded to, %s\n", aws.StringValue(&res.Location))
	return nil
}
