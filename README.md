<p align="center">
	<img width="600" src="./docs/images/theme_daisy.jpg" alt="daisy">
</p>

# Daisy

Daisy a wordpress theme.

Theme daisy is a simple, responsive and pretty wordpress theme.

[Live Demo](http://chenquan.me), this is my personal blog (chinese).

I have used a lot of blog system, such as hexo, ghost, and jeklly, everyone has their pos and cons. Wordpress may too weight to keep a simple blog article, but her charming function, hackable, and was familiar with me. I like it, I pay a lot of money for my vps to keep my WP site working, and it works well. It keeps my memories.

The daisy theme is a fork form [Jaguar](https://fatesinger.com) and inspired by [Yasuko](https://github.com/foru17/Yasuko).

But Daisy is gradually growing up, and differents from both of above two theme.

If you like daisy, welcome to `star` this repo, if you'd like hacking daisy, don't hastitate, feel free and just do it!

## Hacking Daisy

### Step 1. start up wordpress env

```bash
docker-compose up
```

then you need do some installation steps on `http://localhost:8080`

> Note: the `Daisy` theme has already installed in test wordpress env, you just need active it (Dashboard > Appearance > Themes).

### 2. webpack

webpack has already configured, but you have to run this command first:

```bash
npm install
```

then you can run dev mode:

```bash
npm run dev
```

the file change will trigger building process.

## LICENCE

MIT