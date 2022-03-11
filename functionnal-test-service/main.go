package main

import (
	"encoding/json"
	"fmt"
	"github.com/aws/aws-sdk-go/service/sqs"
	"github.com/back/functionnal-test-service/aws"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/manager"
	"github.com/back/functionnal-test-service/utils/zip"
	"github.com/joho/godotenv"
	"os"
)

func checkEnv() []string {
	var errs []string
	_ = godotenv.Load()
	if os.Getenv("DB_PASSWORD") == "" {
		errs = append(errs, "env viable DB_PASSWORD not define\n")
	}
	if os.Getenv("DB_HOSTS") == "" {
		errs = append(errs, "env viable DB_HOSTS not define\n")
	}
	if os.Getenv("DB_USER") == "" {
		errs = append(errs, "env viable DB_USER not define\n")
	}
	if os.Getenv("DB_PORT") == "" {
		errs = append(errs, "env viable DB_PORT not define\n")
	}
	if os.Getenv("DB_NAME") == "" {
		errs = append(errs, "env viable DB_NAME not define\n")
	}
	if os.Getenv("AWS_ACCESS_KEY_ID") == "" {
		errs = append(errs, "env viable AWS_ACCESS_KEY_ID not define\n")
	}
	if os.Getenv("AWS_SECRET_ACCESS_KEY") == "" {
		errs = append(errs, "env viable AWS_SECRET_ACCESS_KEY not define\n")
	}
	if os.Getenv("AWS_LOAD_CONFIG") == "" {
		errs = append(errs, "env viable AWS_LOAD_CONFIG not define\n")
	}
	if os.Getenv("S3_BUCKET") == "" {
		errs = append(errs, "env viable S3_BUCKET not define\n")
	}
	if os.Getenv("SQS_QUEUE") == "" {
		errs = append(errs, "env viable SQS_QUEUE not define\n")
	}
	return errs
}

func main() {
	errs := checkEnv()
	if len(errs) > 0 {
		fmt.Println(errs)
		return
	}
	dsn := connector.NewMysqlDb(os.Getenv("DB_USER"), os.Getenv("DB_PASSWORD"), os.Getenv("DB_NAME"), os.Getenv("DB_PORT"), os.Getenv("DB_HOSTS"))
	err := dsn.InitDb()
	if err != nil {
		panic(err)
	}

	err = connector.Db.Ping()
	for {
		messages, err := connector.ReceiveMessage()
		if err == nil {
			fmt.Println(err)
			for _, message := range messages.Messages {
				type documentId struct {
					DocumentId string
				}
				di := documentId{}
				err = json.Unmarshal([]byte(*message.Body), &di)
				if err != nil {
					fmt.Println(err)
				}
				err = manager.TemplateManager.Manager(di.DocumentId)
				if err != nil {
					panic(err)
				}
				err := zip.ZipSource("./.export/"+di.DocumentId, "./.export/"+di.DocumentId+".zip")
				if err != nil {
					fmt.Println(err)
				}
				err = aws.UploadFileOnS3(di.DocumentId)
				if err != nil {
					fmt.Println(err)
				}
				err = connector.DeleteMessage(sqs.New(connector.GetSession()), message)
				if err != nil {
					fmt.Println(err)
				}
			}
		} else {
			fmt.Println(err)
		}
	}
}


