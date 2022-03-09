package files

import (
	"os"
)

func CreateFile(url string)   error {
	f, err := os.Create(url)
	if err != nil {
		return err
	}
	defer f.Close()
	return nil
}

func openFile(url string) (*os.File, error)  {
	f, err := os.OpenFile(url, os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
	if err != nil {
		return f, err
	}
	return f, nil
}


func WriteFile(url string, data string) error {
	f, err := openFile(url)
	if err != nil {
		return err
	}
	defer f.Close()
	_, err = f.WriteString(data)
	if err != nil {
		return err
	}
	f.Sync()
	return nil
}