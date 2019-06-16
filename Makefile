.PHONY: setup
setup: build

.PHONY: build
build:
	@echo "Build docker images"
	@DOCKER_BUILDKIT=1 docker build -t osushi/youtube_channel_downloder .
