<p align="center">
	<img width="600" src="./docs/images/theme_daisy.jpg" alt="daisy">
</p>

# Daisy

Daisy a wordpress theme.

Theme daisy is a simple, responsive and pretty wordpress theme.

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