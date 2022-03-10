package main

import (
	"encoding/json"
	"github.com/back/functionnal-test-service/connector"
	"github.com/back/functionnal-test-service/manager"
	"github.com/back/functionnal-test-service/utils/zip"
	"github.com/joho/godotenv"
	"log"
	"os"
)

func checkEnv() []string {
	var errs []string
	err := godotenv.Load()
	if err != nil {
		log.Fatal("Error loading .env file")
	}
	return errs
}

func main() {
	messages, err := connector.ReceiveMessage()
	if err != nil {
		log.Println(err)
		return
	}
	dsn := connector.NewMysqlDb(os.Getenv("DB_USER"), os.Getenv("DB_PASSWORD"), os.Getenv("DB_NAME"), os.Getenv("DB_PORT"), os.Getenv("DB_HOSTS"))
	err = dsn.InitDb()
	if err != nil {
		panic(err)
	}

	err = connector.Db.Ping()
	if err != nil {
		panic(err)
	}
	for _, message := range messages.Messages {
		type documentId struct {
			DocumentId string
		}
		di := documentId{}
		err = json.Unmarshal([]byte(*message.Body), &di)
		if err != nil {
			log.Println(err)
			return
		}
		err = manager.TemplateManager.Manager(di.DocumentId)
		if err != nil {
			panic(err)
		}
		err := zip.ZipSource("./.export/" + di.DocumentId, "./.export/" + di.DocumentId + ".zip")
		if err != nil {
			log.Println(err)
		}
	}
}


