const DEFAULT_REPO = "pisey1993/myportfolio";

function repoConfig() {
  const token = process.env.GITHUB_TOKEN;
  if (!token) {
    throw new Error(
      "Could not save. Set GITHUB_TOKEN (a GitHub personal access token with write access to this repo) in your environment to save from a deployed instance — see README.",
    );
  }
  const repo = process.env.GITHUB_REPO || DEFAULT_REPO;
  const branch = process.env.GITHUB_BRANCH || "main";
  return { token, repo, branch };
}

async function githubFetch(path: string, init?: RequestInit): Promise<Response> {
  const { token, repo } = repoConfig();
  return fetch(`https://api.github.com/repos/${repo}/contents/${path}`, {
    ...init,
    headers: {
      Authorization: `Bearer ${token}`,
      Accept: "application/vnd.github+json",
      "X-GitHub-Api-Version": "2022-11-28",
      ...(init?.headers ?? {}),
    },
    cache: "no-store",
  });
}

/** Fetches a file's current content (decoded) and sha from the repo, or null if it doesn't exist yet. */
export async function getRepoFile(path: string): Promise<{ content: string; sha: string } | null> {
  const { branch } = repoConfig();
  const res = await githubFetch(`${path}?ref=${branch}`);
  if (res.status === 404) return null;
  if (!res.ok) {
    throw new Error(`GitHub API error reading ${path}: ${res.status} ${await res.text()}`);
  }
  const data = (await res.json()) as { content: string; sha: string };
  return { content: Buffer.from(data.content, "base64").toString("utf-8"), sha: data.sha };
}

/** Creates or updates a file in the repo. Pass the current sha (from getRepoFile) when updating an existing file. */
export async function putRepoFile(path: string, content: Buffer | string, message: string, sha?: string): Promise<void> {
  const { branch } = repoConfig();
  const base64 = Buffer.isBuffer(content) ? content.toString("base64") : Buffer.from(content, "utf-8").toString("base64");

  const res = await githubFetch(path, {
    method: "PUT",
    body: JSON.stringify({ message, content: base64, branch, ...(sha ? { sha } : {}) }),
  });

  if (!res.ok) {
    throw new Error(`GitHub API error saving ${path}: ${res.status} ${await res.text()}`);
  }
}
