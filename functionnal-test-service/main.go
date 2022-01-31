package main

func checkEnv() []string {
	var errs []string
	return errs
}

func main() {
	errs := checkEnv()
	if len(errs) > 0 {
		panic(errs)
	}
}